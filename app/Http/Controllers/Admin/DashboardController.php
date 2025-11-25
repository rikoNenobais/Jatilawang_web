<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Buy;
use App\Models\Item;
use App\Models\User;
use App\Models\Review;
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

        // Monthly revenue calculations
        $monthlyRevenueRentals = Rental::where('payment_status', 'terbayar')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');

        $monthlyRevenueBuy = Buy::where('payment_status', 'terbayar')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');

        $monthlyTotalProfit = $monthlyRevenueRentals + $monthlyRevenueBuy;

        // Latest rentals
        $latestRentals = Rental::with('user')
            ->where('payment_status', 'terbayar')
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