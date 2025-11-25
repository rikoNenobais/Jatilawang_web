@extends('layouts.layout-admin')

@section('title', 'Detail Pengguna')
@section('header', 'Detail Pengguna')

@php
    use Illuminate\Support\Carbon;
@endphp

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-lg text-slate-800 mb-1">
                Informasi Pengguna
            </h3>
            <p class="text-sm text-gray-600 mb-4">
                Data pengguna bersifat hanya baca, tidak dapat diubah dari panel admin.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div class="space-y-1">
                    <div>
                        <span class="font-semibold text-slate-700">ID:</span>
                        <span class="text-slate-800">{{ $user->user_id }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-700">Username:</span>
                        <span class="text-slate-800">{{ $user->username }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-700">Nama Lengkap:</span>
                        <span class="text-slate-800">{{ $user->full_name ?: '-' }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-700">Role:</span>
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
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $class }}">
                            {{ $label }}
                        </span>
                    </div>
                </div>

                <div class="space-y-1">
                    <div>
                        <span class="font-semibold text-slate-700">Email:</span>
                        <span class="text-slate-800">{{ $user->email ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-700">No. HP:</span>
                        <span class="text-slate-800">{{ $user->phone_number ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-700">Alamat:</span>
                        <span class="text-slate-800">{{ $user->address ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-slate-700">Terdaftar Sejak:</span>
                        <span class="text-slate-800">
                            {{ $user->created_at
                                ? Carbon::parse($user->created_at)->format('d M Y H:i')
                                : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex justify-between items-center">
                <a href="{{ route('admin.users.index') }}"
                   class="text-sm text-gray-600 hover:underline">
                    &larr; Kembali ke daftar pengguna
                </a>

                <span class="text-[11px] text-gray-400">
                    ID sesi: {{ auth()->id() }}
                </span>
            </div>
        </div>
    </div>
@endsection
