<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Buy;
use App\Models\Item;
use App\Models\User;
use App\Models\Review;
use App\Models\Transaction; // TAMBAH INI
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Total counts
        $totalRentals = Rental::count();
        $totalItems = Item::count();
        $totalUsers = User::count();
        $totalReviews = Review::count();

        // Monthly revenue calculations - PAKAI TRANSACTIONS
        $monthlyRevenue = Transaction::where('payment_status', 'terbayar')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_amount');

        // Breakdown revenue dari transaction items
        $monthlyRevenueBreakdown = Transaction::where('payment_status', 'terbayar')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->with(['transactionItems' => function($query) {
                $query->selectRaw('order_type, SUM(amount) as total')
                      ->groupBy('order_type');
            }])
            ->get();

        $monthlyRevenueRentals = 0;
        $monthlyRevenueBuy = 0;

        foreach ($monthlyRevenueBreakdown as $transaction) {
            foreach ($transaction->transactionItems as $item) {
                if ($item->order_type === 'rental') {
                    $monthlyRevenueRentals += $item->total;
                } elseif ($item->order_type === 'buy') {
                    $monthlyRevenueBuy += $item->total;
                }
            }
        }

        $monthlyTotalProfit = $monthlyRevenue;

        // Latest rentals yang sudah terbayar
        $latestRentals = Rental::whereHas('transaction', function($query) {
                $query->where('payment_status', 'terbayar');
            })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRentals',
            'totalItems',
            'totalUsers',
            'totalReviews',
            'monthlyRevenueRentals',
            'monthlyRevenueBuy',
            'monthlyTotalProfit',
            'latestRentals'
        ));
    }
}