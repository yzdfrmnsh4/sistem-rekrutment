<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-[calc(100vh-16rem)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- User Welcome Banner -->
            <div class="bg-gradient-to-r from-brand-700 via-brand-600 to-sky-600 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute right-0 top-0 -mr-12 -mt-12 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 space-y-2">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Portal Akun Pelamar Aktif</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ $user->name }}!</h1>
                    <div class="flex flex-wrap items-center gap-4 text-xs text-brand-100 font-medium">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $user->email }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $user->no_hp ?? 'Belum diisi' }}
                        </span>
                    </div>
                </div>
                <div class="relative z-10 flex items-center space-x-3">
                    <a href="#lowongan-tersedia" class="px-5 py-3 rounded-xl bg-white text-brand-700 hover:bg-brand-50 font-bold text-xs transition-all shadow-md flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Cari Lowongan Pekerjaan
                    </a>
                </div>
            </div>

            <!-- Flash Alert Messages -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- SECTION 1: Status & Riwayat Lamaran Saya -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Riwayat & Status Lamaran Saya</h2>
                        <p class="text-xs text-slate-500">Pantau hasil verifikasi berkas, jadwal tes/wawancara, dan keputusan kelulusan Anda</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                        Total: {{ $lamarans->count() }} Pendaftaran
                    </span>
                </div>

                @if($lamarans->isEmpty())
                    <div class="text-center py-10 space-y-4">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Belum Ada Lamaran Terdaftar</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">Anda belum mendaftar pada posisi lowongan pekerjaan apapun. Silakan pilih lowongan di bawah ini.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($lamarans as $lamaran)
                            <div class="p-5 rounded-2xl border border-slate-200/90 hover:border-brand-300 bg-slate-50/50 transition-all flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                                <div class="space-y-1.5">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-xs font-mono font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded border border-brand-100">
                                            {{ $lamaran->kode_pendaftaran }}
                                        </span>
                                        <span class="text-[10px] text-slate-400">Didaftar pada: {{ $lamaran->created_at->format('d M Y, H:i') }} WIB</span>
                                    </div>
                                    <h3 class="text-lg font-extrabold text-slate-900">{{ $lamaran->lowongan->judul_posisi }}</h3>
                                    <p class="text-xs text-slate-500 font-medium">Departemen: {{ $lamaran->lowongan->departemen }}</p>

                                    <!-- Alert preview if scheduled -->
                                    @if($lamaran->jadwalSeleksi->count() > 0)
                                        @php $nextSchedule = $lamaran->jadwalSeleksi->last(); @endphp
                                        <div class="mt-2 text-xs font-semibold text-sky-700 bg-sky-50 px-3 py-1.5 rounded-xl border border-sky-100 inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Terjadwal {{ str_replace('_', ' ', $nextSchedule->tahap_seleksi) }}: {{ $nextSchedule->tanggal_waktu->format('d M Y, H:i') }} WIB
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 shrink-0">
                                    <!-- Status Badge -->
                                    @php
                                        $statusClass = [
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'lolos_administrasi' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'tidak_lolos' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            'jadwal_tes' => 'bg-sky-50 text-sky-700 border-sky-200',
                                            'diterima' => 'bg-teal-50 text-teal-700 border-teal-200',
                                            'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                        ][$lamaran->status_lamaran] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                    @endphp
                                    <span class="px-3.5 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wider border {{ $statusClass }}">
                                        {{ str_replace('_', ' ', $lamaran->status_lamaran) }}
                                    </span>

                                    <!-- Detail Action Button -->
                                    <a href="{{ route('pelamar.lamaran.detail', $lamaran->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm">
                                        Detail & Status
                                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- SECTION 2: Lowongan Pekerjaan Aktif -->
            <div id="lowongan-tersedia" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Pilih Lowongan Pekerjaan Aktif</h2>
                        <p class="text-xs text-slate-500">Temukan posisi kerja terbaik di PT Sariling Aneka Energi dan kirimkan lamaran Anda</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700">
                        {{ $lowongans->count() }} Lowongan Dibuka
                    </span>
                </div>

                @if($lowongans->isEmpty())
                    <div class="text-center py-8 text-xs text-slate-500">
                        Saat ini belum ada lowongan pekerjaan aktif yang sedang dibuka.
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($lowongans as $job)
                            @php
                                $alreadyApplied = $lamarans->contains('lowongan_id', $job->id);
                            @endphp
                            <div class="bg-slate-50/70 rounded-2xl p-6 border border-slate-200/80 flex flex-col justify-between hover:border-brand-300 hover:shadow-lg transition-all space-y-4">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase bg-brand-100 text-brand-700">
                                            {{ $job->departemen }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-medium">Kuota: {{ $job->kuota }} Posisi</span>
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-900 line-clamp-1">{{ $job->judul_posisi }}</h3>
                                    
                                    <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                        {{ $job->deskripsi }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-slate-200/60 flex items-center justify-between">
                                    <span class="text-[10px] font-semibold text-slate-500">
                                        Batas: {{ $job->tanggal_tutup ? $job->tanggal_tutup->format('d M Y') : 'Secepatnya' }}
                                    </span>

                                    @if($alreadyApplied)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-100 text-emerald-800">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Sudah Dilamar
                                        </span>
                                    @else
                                        <a href="{{ route('pelamar.lamar.create', $job->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 transition-colors shadow-sm">
                                            Isi Form & Lamar
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
