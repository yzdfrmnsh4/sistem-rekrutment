<x-hrd-layout>
    <x-slot name="header">Modul Laporan Rekapitulasi Rekrutmen</x-slot>

    <div class="space-y-6">
        <!-- Filter & PDF Export Bar -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Rekapitulasi Hasil Rekrutmen Karyawan</h2>
                    <p class="text-xs text-slate-500">Filter data pelamar dan unduh laporan PDF resmi A4 Landscape</p>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('hrd.laporan.exportPdf', request()->all()) }}" class="inline-flex items-center px-6 py-3 rounded-xl font-bold text-xs text-white bg-rose-600 hover:bg-rose-700 transition-all shadow-md shadow-rose-600/25">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Cetak Laporan PDF
                    </a>
                </div>
            </div>

            <!-- Filter Form -->
            <form action="{{ route('hrd.laporan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Posisi Lowongan</label>
                    <select name="lowongan_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50">
                        <option value="">-- Semua Posisi --</option>
                        @foreach($lowongans as $j)
                            <option value="{{ $j->id }}" {{ request('lowongan_id') == $j->id ? 'selected' : '' }}>{{ $j->judul_posisi }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Keputusan</label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50">
                        <option value="">-- Semua Status Diproses --</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima (Lolos)</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="lolos_administrasi" {{ request('status') == 'lolos_administrasi' ? 'selected' : '' }}>Lolos Administrasi</option>
                    </select>
                </div>

                <div class="flex items-end space-x-2">
                    <button type="submit" class="w-full py-2.5 px-4 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl shadow-sm transition-colors">
                        Terapkan Filter
                    </button>
                    @if(request()->hasAny(['lowongan_id', 'status']))
                        <a href="{{ route('hrd.laporan.index') }}" class="py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl text-center">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Preview Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-4 px-6">No. Pendaftaran</th>
                            <th class="py-4 px-6">Nama Pelamar</th>
                            <th class="py-4 px-6">Posisi Lowongan</th>
                            <th class="py-4 px-6">Nilai Tes</th>
                            <th class="py-4 px-6">Nilai Wawancara</th>
                            <th class="py-4 px-6">Keputusan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600 font-medium">
                        @forelse($lamarans as $item)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-6 font-mono font-bold text-brand-600">
                                    {{ $item->kode_pendaftaran }}
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-900">
                                    {{ $item->user->name }}
                                    <div class="text-[11px] font-normal text-slate-400">{{ $item->user->email }}</div>
                                </td>
                                <td class="py-4 px-6 text-slate-800">
                                    {{ $item->lowongan->judul_posisi }}
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-700">
                                    {{ $item->hasilSeleksi->nilai_tes ?? '-' }}
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-700">
                                    {{ $item->hasilSeleksi->nilai_wawancara ?? '-' }}
                                </td>
                                <td class="py-4 px-6">
                                    @if($item->status_lamaran === 'diterima')
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">DITERIMA</span>
                                    @elseif($item->status_lamaran === 'ditolak')
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200">DITOLAK</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">{{ str_replace('_', ' ', $item->status_lamaran) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">Tidak ada data rekapitulasi pelamar yang sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-hrd-layout>
