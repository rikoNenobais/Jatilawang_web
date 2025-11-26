<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Buy;
use App\Models\Item;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Rating as Review;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Total counts - FIX: Hanya peminjaman aktif (sedang_berjalan)
        $totalRentals = Rental::where('order_status', 'sedang_berjalan')->count();
        $totalItem = Item::count();
        $totalUsers = User::count();
        $totalReviews = Review::count();

        // Monthly revenue calculations
        $monthlyRevenueRentals = Transaction::where('payment_status', 'terbayar')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereHas('transactionItems', function($query) {
                $query->where('order_type', 'rental');
            })
            ->sum('total_amount');

        $monthlyRevenueBuy = Transaction::where('payment_status', 'terbayar')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->whereHas('transactionItems', function($query) {
                $query->where('order_type', 'buy');
            })
            ->sum('total_amount');

        $monthlyTotalProfit = $monthlyRevenueRentals + $monthlyRevenueBuy;

        // Latest rentals yang sudah terbayar dan status aktif
        $latestRentals = Rental::whereHas('transaction', function($query) {
                $query->where('payment_status', 'terbayar');
            })
            ->whereIn('order_status', ['dikonfirmasi', 'sedang_berjalan'])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRentals',
            'totalItem',
            'totalUsers',
            'totalReviews',
            'monthlyRevenueRentals',
            'monthlyRevenueBuy',
            'monthlyTotalProfit',
            'latestRentals'
        ));
    }
}