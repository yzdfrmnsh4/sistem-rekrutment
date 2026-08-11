<x-admin-layout>
    <x-slot name="header">Verifikasi Berkas Pelamar</x-slot>

    <div class="space-y-6">
        <!-- Filter & Search Bar -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
            <form action="{{ route('admin.pelamar.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Pencarian Pelamar</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau kode..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Filter Lowongan</label>
                    <select name="lowongan_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50">
                        <option value="">-- Semua Posisi Lowongan --</option>
                        @foreach($lowongans as $job)
                            <option value="{{ $job->id }}" {{ request('lowongan_id') == $job->id ? 'selected' : '' }}>{{ $job->judul_posisi }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Filter Status Verifikasi</label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50">
                        <option value="">-- Semua Status --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Baru)</option>
                        <option value="seleksi_berkas" {{ request('status') == 'seleksi_berkas' ? 'selected' : '' }}>Dalam Ditinjau</option>
                        <option value="lolos_administrasi" {{ request('status') == 'lolos_administrasi' ? 'selected' : '' }}>Lolos Administrasi</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="flex items-end space-x-2">
                    <button type="submit" class="w-full py-2.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-sm transition-colors">
                        Terapkan Filter
                    </button>
                    @if(request()->hasAny(['search', 'lowongan_id', 'status']))
                        <a href="{{ route('admin.pelamar.index') }}" class="py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-center">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Notification Alert -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Applicants Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-4 px-6">Kode & Pelamar</th>
                            <th class="py-4 px-6">Posisi Dilamar</th>
                            <th class="py-4 px-6">Tanggal Daftar</th>
                            <th class="py-4 px-6">Status Administrasi</th>
                            <th class="py-4 px-6 text-right">Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600 font-medium">
                        @forelse($lamarans as $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-6">
                                    <span class="text-[10px] font-mono font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded">{{ $item->kode_pendaftaran }}</span>
                                    <div class="font-bold text-slate-900 text-sm mt-1">{{ $item->user->name }}</div>
                                    <div class="text-slate-400 text-[11px]">{{ $item->user->email }} | {{ $item->user->no_hp ?? '-' }}</div>
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-800">
                                    {{ $item->lowongan->judul_posisi }}
                                </td>
                                <td class="py-4 px-6 text-slate-500">
                                    {{ $item->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="py-4 px-6">
                                    @if($item->status_lamaran === 'pending')
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">Pending</span>
                                    @elseif($item->status_lamaran === 'lolos_administrasi')
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">Lolos Administrasi</span>
                                    @elseif($item->status_lamaran === 'ditolak')
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200">Ditolak</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-sky-50 text-sky-700 border border-sky-200">{{ str_replace('_', ' ', $item->status_lamaran) }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('admin.pelamar.show', $item->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 transition-all shadow-sm">
                                        Review Berkas
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">Tidak ada data pendaftaran pelamar yang sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($lamarans->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $lamarans->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
