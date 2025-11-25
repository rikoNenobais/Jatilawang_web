@extends('layouts.layout-admin')

@section('title', 'Pengguna')
@section('header', 'Daftar Pengguna')

@php
    use Illuminate\Support\Carbon;
@endphp

@section('content')
    {{-- Judul + info kecil --}}
    <div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h3 class="font-semibold text-lg text-slate-800 mb-1">Daftar Pengguna</h3>
            <p class="text-sm text-gray-600">
                Admin hanya dapat melihat informasi pengguna tanpa mengubah data.
            </p>
        </div>
    </div>

    {{-- Info jumlah --}}
    <div class="mb-3 text-xs text-gray-500">
        Menampilkan
        <span class="font-semibold">{{ $users->count() }}</span>
        dari
        <span class="font-semibold">{{ $users->total() }}</span>
        pengguna.
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full text-sm">
            <thead>
            <tr class="border-b bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <th class="text-left px-3 py-2">ID</th>
                <th class="text-left px-3 py-2">User</th>
                <th class="text-left px-3 py-2">Kontak</th>
                <th class="text-left px-3 py-2">Role</th>
                <th class="text-left px-3 py-2">Terdaftar</th>
                <th class="text-right px-3 py-2">Detail</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
                @php
                    $role = $user->role ?? 'customer';
                    $label = strtoupper($role);
                    $class = match ($role) {
                        'admin'    => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                        'staff'    => 'bg-amber-50 text-amber-700 border-amber-100',
                        'owner'    => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                        default    => 'bg-gray-50 text-gray-700 border-gray-200',
                    };
                @endphp

                <tr class="hover:bg-gray-50/70">
                    {{-- ID --}}
                    <td class="px-3 py-2 text-gray-800">
                        #{{ $user->user_id }}
                    </td>

                    {{-- User (nama + username) --}}
                    <td class="px-3 py-2">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $user->full_name ?: $user->username }}
                        </div>
                        <div class="text-[11px] text-gray-500">
                            {{ $user->username }}
                        </div>
                    </td>

                    {{-- Kontak --}}
                    <td class="px-3 py-2">
                        <div class="text-sm text-gray-800">
                            {{ $user->email ?? '-' }}
                        </div>
                        @if($user->phone_number)
                            <div class="text-[11px] text-gray-500">
                                {{ $user->phone_number }}
                            </div>
                        @endif
                    </td>

                    {{-- Role --}}
                    <td class="px-3 py-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $class }}">
                            {{ $label }}
                        </span>
                    </td>

                    {{-- Terdaftar --}}
                    <td class="px-3 py-2 text-sm text-gray-600 whitespace-nowrap">
                        {{ $user->created_at
                            ? Carbon::parse($user->created_at)->format('d M Y H:i')
                            : '-' }}
                    </td>

                    {{-- Detail --}}
                    <td class="px-3 py-2 text-right">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-lg border
                                  border-gray-200 text-gray-700 hover:bg-gray-50">
                            Lihat
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-3 py-6 text-center text-gray-400" colspan="6">
                        Belum ada data pengguna.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endsection
