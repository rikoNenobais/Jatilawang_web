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

    public function financialReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $start = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->startOfMonth();
        $end = $endDate ? Carbon::parse($endDate)->endOfDay() : now()->endOfMonth();

        $transactions = Transaction::with(['user', 'transactionItems'])
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->get();

        $paidTransactions = $transactions->where('payment_status', 'terbayar');

        $summary = [
            'total_revenue' => $paidTransactions->sum('total_amount'),
            'pending_amount' => $transactions->whereIn('payment_status', ['menunggu_pembayaran', 'menunggu_verifikasi'])->sum('total_amount'),
            'failed_amount' => $transactions->where('payment_status', 'gagal')->sum('total_amount'),
            'transaction_count' => $transactions->count(),
        ];

        $typeBreakdown = [
            'rental' => 0,
            'buy' => 0,
        ];

        foreach ($paidTransactions as $transaction) {
            foreach ($transaction->transactionItems as $item) {
                if (! array_key_exists($item->order_type, $typeBreakdown)) {
                    $typeBreakdown[$item->order_type] = 0;
                }

                $typeBreakdown[$item->order_type] += $item->amount;
            }
        }

        $paymentMethodBreakdown = $paidTransactions
            ->groupBy('payment_method')
            ->map(function ($group) {
                return $group->sum('total_amount');
            });

        $monthlyTrend = Transaction::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, SUM(total_amount) as total')
            ->where('payment_status', 'terbayar')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return view('admin.financial-report', [
            'transactions' => $transactions,
            'summary' => $summary,
            'typeBreakdown' => $typeBreakdown,
            'paymentMethodBreakdown' => $paymentMethodBreakdown,
            'monthlyTrend' => $monthlyTrend,
            'start' => $start,
            'end' => $end,
        ]);
    }
}