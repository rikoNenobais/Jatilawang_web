@extends('layouts.layout-admin')

@section('title', 'Review Pengguna')
@section('header', 'Review Pengguna')

@php
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Str;
@endphp

@section('content')
    {{-- Bar atas --}}
    <div class="mb-4 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <div>
            <h3 class="font-semibold text-lg text-slate-800 mb-1">Daftar Review</h3>
            <p class="text-sm text-gray-600">
                Admin dapat mengawasi dan memoderasi review yang diberikan pengguna.
            </p>
        </div>

        <form method="GET" class="flex gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-64">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    🔍
                </span>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari user / produk / komentar..."
                    class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-xl text-sm
                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>
            <select
                name="verified"
                class="px-3 py-2 border border-gray-200 rounded-xl text-sm bg-white
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
                <option value="">Semua status</option>
                <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>Belum verifikasi</option>
            </select>
            <button
                class="px-4 py-2 bg-slate-900 text-white text-sm rounded-xl flex items-center gap-1
                       hover:bg-slate-800">
                Filter
            </button>
        </form>
    </div>

    {{-- Info kecil --}}
    <div class="mb-3 text-xs text-gray-500">
        Menampilkan
        <span class="font-semibold">{{ $reviews->count() }}</span>
        dari
        <span class="font-semibold">{{ $reviews->total() }}</span>
        review.
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full text-sm">
            <thead>
            <tr class="border-b bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <th class="text-left px-3 py-2">ID</th>
                <th class="text-left px-3 py-2">User</th>
                <th class="text-left px-3 py-2">Produk / Key</th>
                <th class="text-left px-3 py-2">Rating</th>
                <th class="text-left px-3 py-2">Komentar</th>
                <th class="text-left px-3 py-2">Status</th>
                <th class="text-left px-3 py-2">Tanggal</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse($reviews as $review)
                <tr class="align-top hover:bg-gray-50/70">
                    {{-- ID --}}
                    <td class="px-3 py-2 text-gray-800">
                        #{{ $review->id }}
                        <div class="text-[11px] text-gray-400">
                            User ID: {{ $review->user_id }}
                        </div>
                    </td>

                    {{-- User --}}
                    <td class="px-3 py-2">
                        @if($review->relationLoaded('user') || $review->user)
                            <div class="text-sm font-medium text-gray-900">
                                {{ $review->user->full_name ?? $review->user->username ?? 'User #'.$review->user_id }}
                            </div>
                            <div class="text-[11px] text-gray-500">
                                {{ $review->user->email ?? '' }}
                            </div>
                        @else
                            <div class="text-sm text-gray-800">
                                User #{{ $review->user_id }}
                            </div>
                        @endif
                    </td>

                    {{-- Produk / Key --}}
                    <td class="px-3 py-2">
                        <div class="text-sm font-medium text-gray-800">
                            {{ $review->product_key }}
                        </div>
                    </td>

                    {{-- Rating --}}
                    <td class="px-3 py-2">
                        <div class="flex items-center gap-1">
                            <span class="font-semibold text-gray-900">
                                {{ $review->rating }} / 5
                            </span>
                        </div>
                        <div class="mt-1 flex gap-0.5 text-xs">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <span class="text-amber-400">★</span>
                                @else
                                    <span class="text-gray-300">★</span>
                                @endif
                            @endfor
                        </div>
                    </td>

                    {{-- Komentar --}}
                    <td class="px-3 py-2 max-w-md">
                        <div class="text-sm text-gray-800">
                            {{ Str::limit($review->comment, 140) }}
                        </div>
                    </td>

                    {{-- Status --}}
                    <td class="px-3 py-2">
                        @if($review->verified)
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold
                                       bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Terverifikasi
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold
                                       bg-gray-50 text-gray-700 border border-gray-200">
                                Belum verifikasi
                            </span>
                        @endif
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-3 py-2 text-sm text-gray-600 whitespace-nowrap">
                        {{ $review->created_at
                            ? Carbon::parse($review->created_at)->format('d M Y H:i')
                            : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-3 py-6 text-center text-gray-400" colspan="7">
                        Belum ada review dari pengguna.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $reviews->withQueryString()->links() }}
    </div>
@endsection
