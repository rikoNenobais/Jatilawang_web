<?php

namespace App\Services;

use App\Models\DetailBuy;
use App\Models\DetailRental;
use App\Models\Item;
use Closure;
use Illuminate\Support\Collection;

class ItemRecommendationService
{
    public function forItem(Item $item, int $limit = 5): array
    {
        if (($item->is_rentable ?? false) && ($item->rental_stock ?? 0) > 0) {
            $coRentals = $this->coRentedTogether($item, $limit);
            if ($coRentals->isNotEmpty()) {
                return [
                    'items' => $coRentals,
                    'source' => 'rent',
                ];
            }
        }

        $fallback = $this->coBoughtTogether($item, $limit);

        return [
            'items' => $fallback,
            'source' => $fallback->isNotEmpty() ? 'buy' : null,
        ];
    }

    private function coRentedTogether(Item $item, int $limit): Collection
    {
        $rentalIds = DetailRental::where('item_id', $item->item_id)->pluck('rental_id');

        if ($rentalIds->isEmpty()) {
            return collect();
        }

        $stats = DetailRental::selectRaw('item_id, COUNT(*) as frequency, SUM(quantity) as total_quantity')
            ->whereIn('rental_id', $rentalIds)
            ->where('item_id', '!=', $item->item_id)
            ->groupBy('item_id')
            ->orderByDesc('frequency')
            ->orderByDesc('total_quantity')
            ->limit($limit * 2)
            ->get();

        return $this->hydrateItems($stats, function ($query) {
            $query->where('is_rentable', true)
                ->where('rental_stock', '>', 0);
        }, $limit);
    }

    private function coBoughtTogether(Item $item, int $limit): Collection
    {
        $buyIds = DetailBuy::where('item_id', $item->item_id)->pluck('buy_id');

        if ($buyIds->isEmpty()) {
            return collect();
        }

        $stats = DetailBuy::selectRaw('item_id, COUNT(*) as frequency, SUM(quantity) as total_quantity')
            ->whereIn('buy_id', $buyIds)
            ->where('item_id', '!=', $item->item_id)
            ->groupBy('item_id')
            ->orderByDesc('frequency')
            ->orderByDesc('total_quantity')
            ->limit($limit * 2)
            ->get();

        return $this->hydrateItems($stats, function ($query) {
            $query->where('is_sellable', true)
                ->where('sale_stock', '>', 0);
        }, $limit);
    }

    private function hydrateItems(Collection $stats, Closure $constraints, int $limit): Collection
    {
        $orderedIds = $stats->pluck('item_id');

        if ($orderedIds->isEmpty()) {
            return collect();
        }

        $itemsQuery = Item::whereIn('item_id', $orderedIds);
        $constraints($itemsQuery);

        $items = $itemsQuery->get()->keyBy('item_id');

        $orderedItems = collect();

        foreach ($stats as $stat) {
            if (!$items->has($stat->item_id)) {
                continue;
            }

            $item = $items->get($stat->item_id);
            $item->setAttribute('recommendation_frequency', (int) $stat->frequency);
            $item->setAttribute('recommendation_total_quantity', (int) $stat->total_quantity);

            $orderedItems->push($item);

            if ($orderedItems->count() >= $limit) {
                break;
            }
        }

        return $orderedItems;
    }
}
