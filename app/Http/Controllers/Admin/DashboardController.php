<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buy;
use App\Models\Rental;
use App\Models\Item;
use App\Models\User;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRentals = Rental::count();
        $totalItems   = Item::count();
        $totalUsers   = User::count();
        $totalReviews = Review::count();

        // Hanya pendapatan yang statusnya terbayar/terverifikasi
        $totalRevenueRentals = Rental::where('payment_status', 'terbayar')->sum('total_price');
        $totalRevenueBuy = Buy::where('payment_status', 'terbayar')->sum('total_price');
        $totalProfit = $totalRevenueRentals + $totalRevenueBuy;

        $latestRentals = Rental::with('user')
            ->where('payment_status', 'terbayar') // Hanya yang sudah bayar
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRentals',
            'totalItems',
            'totalUsers',
            'totalReviews',
            'totalRevenueRentals',
            'totalRevenueBuy',
            'totalProfit',
            'latestRentals'
        ));
    }
}