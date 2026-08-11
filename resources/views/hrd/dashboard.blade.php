<x-hrd-layout>
    <x-slot name="header">Dashboard Executive HRD</x-slot>

    <div class="space-y-8">
        <!-- Overview Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Lowongan Terpublikasi</span>
                    <span class="text-3xl font-extrabold text-slate-900 mt-1 block">{{ $lowonganAktif }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m46 0v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6m14 6v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6"></path>
                    </svg>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Aplikasi masuk</span>
                    <span class="text-3xl font-extrabold text-slate-900 mt-1 block">{{ $totalLamaran }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Pelamar Diterima</span>
                    <span class="text-3xl font-extrabold text-emerald-600 mt-1 block">{{ $pelamarDiterima }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Pelamar Ditolak</span>
                    <span class="text-3xl font-extrabold text-rose-600 mt-1 block">{{ $pelamarDitolak }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Executive Report Banner -->
        <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center md:text-left">
                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Laporan Rekapitulasi Executive</h3>
                <p class="text-xs text-slate-500 max-w-xl">Unduh dan cetak rekapitulasi data calon karyawan yang telah diterima melalui PDF siap cetak berformat A4 Landscape.</p>
            </div>
            <a href="{{ url('/hrd/laporan') }}" class="px-6 py-3 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm transition-all shadow-md shadow-teal-600/25 shrink-0">
                Buka Modul Laporan PDF
            </a>
        </div>
    </div>
</x-hrd-layout>
