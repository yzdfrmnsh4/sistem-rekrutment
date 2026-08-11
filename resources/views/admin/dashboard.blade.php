<x-admin-layout>
    <x-slot name="header">Dashboard Administrator</x-slot>

    <div class="space-y-8">
        <!-- Overview Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Lowongan Aktif</span>
                    <span class="text-3xl font-extrabold text-slate-900 mt-1 block">{{ $totalLowongan }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m46 0v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6m14 6v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6"></path>
                    </svg>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Pelamar</span>
                    <span class="text-3xl font-extrabold text-slate-900 mt-1 block">{{ $totalPelamar }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Lamaran</span>
                    <span class="text-3xl font-extrabold text-slate-900 mt-1 block">{{ $totalLamaran }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Pending Verifikasi</span>
                    <span class="text-3xl font-extrabold text-amber-600 mt-1 block">{{ $lamaranPending }}</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quick Access Section -->
        <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
            <h3 class="text-lg font-bold text-slate-900 tracking-tight">Aksi Cepat Pengelolaan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ url('/admin/lowongan') }}" class="p-6 rounded-2xl bg-slate-50 border border-slate-200/60 hover:border-brand-300 hover:bg-brand-50/50 transition-all group">
                    <h4 class="font-bold text-slate-900 group-hover:text-brand-600 transition-colors">Kelola Lowongan Pekerjaan</h4>
                    <p class="text-xs text-slate-500 mt-1">Tambah, perbarui, atau tutup posisi lowongan karir.</p>
                </a>
                <a href="{{ url('/admin/pelamar') }}" class="p-6 rounded-2xl bg-slate-50 border border-slate-200/60 hover:border-brand-300 hover:bg-brand-50/50 transition-all group">
                    <h4 class="font-bold text-slate-900 group-hover:text-brand-600 transition-colors">Verifikasi Berkas Pelamar</h4>
                    <p class="text-xs text-slate-500 mt-1">Review dokumen CV, Ijazah, dan KTP pelamar baru.</p>
                </a>
                <a href="{{ url('/admin/jadwal') }}" class="p-6 rounded-2xl bg-slate-50 border border-slate-200/60 hover:border-brand-300 hover:bg-brand-50/50 transition-all group">
                    <h4 class="font-bold text-slate-900 group-hover:text-brand-600 transition-colors">Atur Jadwal Seleksi</h4>
                    <p class="text-xs text-slate-500 mt-1">Tetapkan tanggal tes online & wawancara.</p>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
