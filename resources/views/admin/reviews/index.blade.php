@extends('layouts.layout-admin')

@section('title', 'Review Pengguna')
@section('header', 'Manajemen Review')

@php
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Str;
@endphp

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Review</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola semua review yang diberikan pengguna</p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 flex flex-col sm:flex-row gap-3">
                    {{-- Search --}}
                    <div class="flex-1 relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Cari user, produk, atau komentar..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm
                                focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>

                    {{-- Rating Filter --}}
                    <div class="sm:w-48">
                        <select
                            name="rating"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm
                                focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                        >
                            <option value="">Semua Rating</option>
                            <option value="5" {{ request('rating') === '5' ? 'selected' : '' }}>⭐ 5 Bintang</option>
                            <option value="4" {{ request('rating') === '4' ? 'selected' : '' }}>⭐ 4 Bintang</option>
                            <option value="3" {{ request('rating') === '3' ? 'selected' : '' }}>⭐ 3 Bintang</option>
                            <option value="2" {{ request('rating') === '2' ? 'selected' : '' }}>⭐ 2 Bintang</option>
                            <option value="1" {{ request('rating') === '1' ? 'selected' : '' }}>⭐ 1 Bintang</option>
                        </select>
                    </div>
                </div>

                <button
                    class="px-4 py-2.5 bg-gray-900 text-white text-sm rounded-lg hover:bg-gray-800 
                        transition-colors flex items-center gap-2 justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                    </svg>
                    Filter
                </button>
            </form>
        </div>
    </div>

    {{-- Info --}}
    <div class="mb-4 flex items-center justify-between">
        <p class="text-sm text-gray-600">
            Menampilkan <span class="font-semibold text-gray-900">{{ $reviews->count() }}</span> dari 
            <span class="font-semibold text-gray-900">{{ $reviews->total() }}</span> review
        </p>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Review
                        </th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Produk & Order
                        </th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Rating
                        </th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="text-right py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50 transition-colors">
                            {{-- Review --}}
                            <td class="py-4 px-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm flex-shrink-0">
                                        {{ substr($review->user->full_name ?? $review->user->username ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <p class="font-semibold text-gray-900 truncate">
                                                {{ $review->user->full_name ?? $review->user->username ?? 'User #'.$review->user_id }}
                                            </p>
                                            <span class="text-xs text-gray-500 font-mono bg-gray-100 px-1.5 py-0.5 rounded">
                                                #{{ $review->rating_id }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 line-clamp-2">
                                            {{ $review->comment ?: 'Tidak ada komentar' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $review->user->email ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Produk & Order --}}
                            <td class="py-4 px-6">
                                <div class="space-y-2">
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">
                                            {{ $review->item->item_name ?? 'Produk #'.$review->item_id }}
                                        </p>
                                    </div>
                                    <div class="flex flex-wrap gap-1">
                                        @if($review->rental_id)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                Sewa #{{ $review->rental_id }}
                                            </span>
                                        @elseif($review->buy_id)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                Beli #{{ $review->buy_id }}
                                            </span>
                                        @endif
                                        @if($review->transaction_id)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                Trans #{{ $review->transaction_id }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Rating --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <div class="flex gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating_value)
                                                <svg class="h-5 w-5 text-amber-400 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @else
                                                <svg class="h-5 w-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="font-semibold text-gray-900 text-sm">
                                        {{ $review->rating_value }}/5
                                    </span>
                                </div>
                            </td>

                            {{-- Tanggal --}}
                            <td class="py-4 px-6">
                                <div class="text-sm text-gray-900">
                                    {{ $review->created_at ? Carbon::parse($review->created_at)->format('d M Y') : '-' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $review->created_at ? Carbon::parse($review->created_at)->format('H:i') : '' }}
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="py-4 px-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.reviews.show', $review) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 
                                            text-xs font-medium rounded-lg hover:bg-blue-100 transition-colors">
                                        Detail
                                    </a>
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 
                                                       text-xs font-medium rounded-lg hover:bg-red-100 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-500">Belum ada review</p>
                                    <p class="text-sm mt-1">Review dari pengguna akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $reviews->withQueryString()->links() }}
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection