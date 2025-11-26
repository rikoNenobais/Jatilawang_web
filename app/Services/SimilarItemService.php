<?php

namespace App\Services;

use App\Models\DetailBuy;
use App\Models\DetailRental;
use App\Models\Item;
use Illuminate\Support\Collection;

class SimilarItemService
{
    public function forItem(Item $item, int $limit = 6): Collection
    {
        $basePrice = $this->resolveBasePrice($item);

        $rentalStats = DetailRental::selectRaw('item_id, SUM(quantity) as rental_popularity')
            ->groupBy('item_id');

        $buyStats = DetailBuy::selectRaw('item_id, SUM(quantity) as buy_popularity')
            ->groupBy('item_id');

        $query = Item::query()
            ->select('items.*')
            ->selectRaw('COALESCE(rent_stats.rental_popularity, 0) + COALESCE(buy_stats.buy_popularity, 0) as popularity_score')
            ->selectRaw('ABS(COALESCE(items.rental_price_per_day, items.sale_price, 0) - ?) as price_distance', [$basePrice])
            ->leftJoinSub($rentalStats, 'rent_stats', function ($join) {
                $join->on('items.item_id', '=', 'rent_stats.item_id');
            })
            ->leftJoinSub($buyStats, 'buy_stats', function ($join) {
                $join->on('items.item_id', '=', 'buy_stats.item_id');
            })
            ->where('items.category', $item->category)
            ->where('items.item_id', '!=', $item->item_id);

        if ($item->is_rentable && $item->is_sellable) {
            $query->where(function ($sub) {
                $sub->where(function ($rent) {
                    $rent->where('items.is_rentable', true)
                        ->where('items.rental_stock', '>', 0);
                })->orWhere(function ($buy) {
                    $buy->where('items.is_sellable', true)
                        ->where('items.sale_stock', '>', 0);
                });
            });
        } elseif ($item->is_rentable) {
            $query->where('items.is_rentable', true)
                ->where('items.rental_stock', '>', 0);
        } elseif ($item->is_sellable) {
            $query->where('items.is_sellable', true)
                ->where('items.sale_stock', '>', 0);
        } else {
            $query->where(function ($fallback) {
                $fallback->where('items.rental_stock', '>', 0)
                    ->orWhere('items.sale_stock', '>', 0);
            });
        }

        $items = $query
            ->orderBy('price_distance')
            ->orderByDesc('popularity_score')
            ->orderByDesc('items.created_at')
            ->limit($limit)
            ->get();

        if ($items->isNotEmpty()) {
            return $items;
        }

        return Item::query()
            ->where('category', $item->category)
            ->where('item_id', '!=', $item->item_id)
            ->latest()
            ->take($limit)
            ->get();
    }

    private function resolveBasePrice(Item $item): float
    {
        if ($item->is_rentable && $item->rental_price_per_day) {
            return (float) $item->rental_price_per_day;
        }

        if ($item->is_sellable && $item->sale_price) {
            return (float) $item->sale_price;
        }

        return (float) ($item->sale_price ?? $item->rental_price_per_day ?? 0);
    }
}
