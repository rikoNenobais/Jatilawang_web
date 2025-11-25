@extends('layouts.layout-admin')

@section('title', 'Pengguna')
@section('header', 'Manajemen Pengguna')

@php
    use Illuminate\Support\Carbon;
@endphp

@section('content')
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Pengguna</h1>
                <p class="text-sm text-gray-600 mt-1">Kelola semua pengguna terdaftar di sistem</p>
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
                            placeholder="Cari nama, username, atau email..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>

                    {{-- Role Filter --}}
                    <div class="sm:w-48">
                        <select
                            name="role"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white"
                        >
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
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
            Menampilkan <span class="font-semibold text-gray-900">{{ $users->count() }}</span> dari 
            <span class="font-semibold text-gray-900">{{ $users->total() }}</span> pengguna
        </p>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Pengguna
                        </th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Kontak
                        </th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Role
                        </th>
                        <th class="text-left py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Terdaftar
                        </th>
                        <th class="text-right py-4 px-6 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        @php
                            $role = $user->role ?? 'customer';
                            $roleColors = [
                                'admin' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                'staff' => 'bg-amber-100 text-amber-800 border-amber-200',
                                'customer' => 'bg-gray-100 text-gray-800 border-gray-200',
                            ];
                            $roleLabels = [
                                'admin' => 'ADMIN',
                                'staff' => 'STAFF', 
                                'customer' => 'CUSTOMER',
                            ];
                        @endphp

                        <tr class="hover:bg-gray-50 transition-colors">
                            {{-- Pengguna --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                        {{ substr($user->full_name ?: $user->username, 0, 1) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <p class="font-semibold text-gray-900 truncate">
                                                {{ $user->full_name ?: $user->username }}
                                            </p>
                                            <span class="text-xs text-gray-500 font-mono bg-gray-100 px-1.5 py-0.5 rounded">
                                                #{{ $user->user_id }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $user->username }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Kontak --}}
                            <td class="py-4 px-6">
                                <div class="text-sm text-gray-900">{{ $user->email ?? '-' }}</div>
                                @if($user->phone_number)
                                    <div class="text-xs text-gray-500 mt-1">{{ $user->phone_number }}</div>
                                @endif
                            </td>

                            {{-- Role --}}
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $roleColors[$role] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                    {{ $roleLabels[$role] ?? strtoupper($role) }}
                                </span>
                            </td>

                            {{-- Terdaftar --}}
                            <td class="py-4 px-6">
                                <div class="text-sm text-gray-900">
                                    {{ $user->created_at ? Carbon::parse($user->created_at)->format('d M Y') : '-' }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $user->created_at ? Carbon::parse($user->created_at)->format('H:i') : '' }}
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 
                                          text-xs font-medium rounded-lg hover:bg-blue-100 transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                    <p class="text-lg font-medium text-gray-500">Belum ada pengguna</p>
                                    <p class="text-sm mt-1">Data pengguna akan muncul di sini</p>
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
        {{ $users->withQueryString()->links() }}
    </div>
@endsection