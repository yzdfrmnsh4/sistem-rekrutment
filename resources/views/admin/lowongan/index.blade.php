<x-admin-layout>
    <x-slot name="header">Kelola Lowongan Pekerjaan</x-slot>

    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Daftar Lowongan Karir</h2>
                <p class="text-xs text-slate-500">Kelola posisi lowongan pekerjaan yang dipublikasikan ke pelamar</p>
            </div>
            <a href="{{ route('admin.lowongan.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-bold text-xs text-white bg-brand-600 hover:bg-brand-700 transition-all shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Lowongan Baru
            </a>
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

        <!-- Lowongan Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-4 px-6">Posisi & Departemen</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6">Kuota</th>
                            <th class="py-4 px-6">Pelamar</th>
                            <th class="py-4 px-6">Batas Waktu</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600 font-medium">
                        @forelse($lowongans as $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900 text-sm">{{ $item->judul_posisi }}</div>
                                    <div class="text-slate-400 text-[11px]">{{ $item->departemen }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($item->status === 'published')
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">Published</span>
                                    @elseif($item->status === 'draft')
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">Draft</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200">Closed</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-800">{{ $item->kuota }} Orang</td>
                                <td class="py-4 px-6">
                                    <span class="px-2 py-0.5 rounded bg-brand-50 text-brand-700 font-bold">{{ $item->lamaran_count }} Lamaran</span>
                                </td>
                                <td class="py-4 px-6 text-slate-500">
                                    {{ $item->tanggal_tutup->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <a href="{{ route('admin.lowongan.edit', $item->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.lowongan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">Belum ada lowongan pekerjaan. Klik "Tambah Lowongan Baru".</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
