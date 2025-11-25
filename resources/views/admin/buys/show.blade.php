@extends('layouts.layout-admin')

@section('title', 'Detail Pembelian')
@section('header', 'Detail Pembelian')

@php
    use Illuminate\Support\Carbon;
@endphp

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Informasi Pembelian --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Informasi Pembelian
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID Pembelian</label>
                            <p class="text-lg font-mono font-semibold text-gray-900">#{{ $buy->buy_id }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                    {{ substr(optional($buy->user)->full_name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ optional($buy->user)->full_name ?? optional($buy->user)->username ?? 'User #'.$buy->user_id }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ optional($buy->user)->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Order</label>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-medium">Order:</span>
                                <span class="text-sm">{{ Carbon::parse($buy->order_date)->format('d F Y H:i') }}</span>
                            </div>
                            @if($buy->shipped_at)
                            <div class="flex items-center gap-2 mt-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm font-medium">Dikirim:</span>
                                <span class="text-sm">{{ Carbon::parse($buy->shipped_at)->format('d F Y H:i') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4">
                        @php
                            $statusColors = [
                                'menunggu_verifikasi' => 'bg-orange-100 text-orange-800 border-orange-200',
                                'dikonfirmasi' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'diproses' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'dikirim' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                'selesai' => 'bg-green-100 text-green-800 border-green-200',
                                'dibatalkan' => 'bg-red-100 text-red-800 border-red-200'
                            ];

                            $statusLabels = [
                                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                'dikonfirmasi' => 'Dikonfirmasi',
                                'diproses' => 'Diproses',
                                'dikirim' => 'Dikirim',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan'
                            ];
                        @endphp

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Order</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusColors[$buy->order_status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                {{ $statusLabels[$buy->order_status] ?? $buy->order_status }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                            @if($buy->transaction)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if($buy->transaction->payment_status === 'terbayar') bg-green-100 text-green-800 border-green-200
                                    @elseif($buy->transaction->payment_status === 'menunggu_verifikasi') bg-yellow-100 text-yellow-800 border-yellow-200
                                    @elseif($buy->transaction->payment_status === 'menunggu_pembayaran') bg-blue-100 text-blue-800 border-blue-200
                                    @else bg-red-100 text-red-800 border-red-200 @endif">
                                    {{ str_replace('_', ' ', $buy->transaction->payment_status) }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">
                                    TRX-{{ $buy->transaction->transaction_id }}
                                </p>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border-gray-200">
                                    Belum ada transaksi
                                </span>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Pembayaran</label>
                            <p class="text-lg font-bold text-gray-900">
                                Rp {{ number_format($buy->total_price ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Item yang Dibeli --}}
            @if($buy->detailBuys->count())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Item yang Dibeli
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Item</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Kuantitas</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Harga Satuan</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($buy->detailBuys as $detail)
                            @php
                                $hargaSatuan = $detail->quantity > 0 ? $detail->total_price / $detail->quantity : 0;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold">
                                            {{ substr($detail->item->item_name ?? 'I', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $detail->item->item_name ?? 'Item #'.$detail->item_id }}</p>
                                            <p class="text-xs text-gray-500">ID: {{ $detail->item_id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-gray-600">{{ $detail->quantity }}</td>
                                <td class="py-3 px-4 text-gray-600">
                                    Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 font-medium text-gray-900">
                                    Rp {{ number_format($detail->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                            
                            <tr class="bg-gray-50 font-semibold">
                                <td colspan="3" class="py-3 px-4 text-right">Total:</td>
                                <td class="py-3 px-4 text-gray-900">
                                    Rp {{ number_format($buy->total_price ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Informasi Pengiriman & Pembayaran --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Informasi Pengiriman & Pembayaran
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                            @if($buy->transaction)
                                <p class="text-sm text-gray-900 capitalize">{{ $buy->transaction->payment_method ?? '-' }}</p>
                            @else
                                <p class="text-sm text-gray-500">Belum ada transaksi</p>
                            @endif
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Pembayaran</label>
                            @if($buy->transaction && $buy->transaction->payment_proof)
                            <a href="{{ asset('storage/' . $buy->transaction->payment_proof) }}" target="_blank"
                               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 text-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Bukti Bayar
                            </a>
                            @else
                            <p class="text-sm text-gray-500">Belum upload bukti</p>
                            @endif
                        </div>

                        @if($buy->transaction)
                        <div>
                            <a href="{{ route('admin.transactions.show', $buy->transaction) }}" 
                               class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Lihat Detail Transaksi
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Opsi Pengiriman</label>
                            <p class="text-sm text-gray-900 capitalize">{{ $buy->delivery_option ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                            @if($buy->shipping_address)
                            <p class="text-sm text-gray-900">{{ $buy->shipping_address }}</p>
                            @else
                            <p class="text-sm text-gray-500">Pickup di tempat</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Aksi --}}
        <div class="space-y-6">
            {{-- Kelola Pembelian --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kelola Pembelian</h3>
                
                <form action="{{ route('admin.buys.update', $buy) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Order</label>
                        <select name="order_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="menunggu_verifikasi" {{ $buy->order_status == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="dikonfirmasi" {{ $buy->order_status == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="diproses" {{ $buy->order_status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ $buy->order_status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $buy->order_status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $buy->order_status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Pengiriman</label>
                        <textarea name="shipping_address" rows="3" 
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Alamat lengkap pengiriman">{{ $buy->shipping_address ?? '' }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- Info Cepat --}}
            <div class="bg-blue-50 rounded-xl border border-blue-200 p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">Info Cepat</h3>
                <div class="space-y-2 text-sm text-blue-800">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Jumlah Item: {{ $buy->detailBuys->count() }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Dibuat: {{ $buy->created_at->diffForHumans() }}</span>
                    </div>
                    @if($buy->transaction && $buy->transaction->paid_at)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Dibayar: {{ Carbon::parse($buy->transaction->paid_at)->diffForHumans() }}</span>
                    </div>
                    @endif
                    @if($buy->shipped_at)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Dikirim: {{ Carbon::parse($buy->shipped_at)->diffForHumans() }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Navigasi --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <a href="{{ route('admin.buys.index') }}"
                   class="w-full inline-flex items-center justify-center gap-2 bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection