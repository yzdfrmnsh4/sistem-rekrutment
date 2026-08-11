<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-[calc(100vh-16rem)]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Back Navigation -->
            <div>
                <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Daftar Lowongan
                </a>
            </div>

            <!-- Job Main Card Header -->
            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/80 shadow-xl space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-brand-50 text-brand-700 border border-brand-100 mb-2">
                            {{ $lowongan->departemen }}
                        </span>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $lowongan->judul_posisi }}</h1>
                        <p class="text-sm text-slate-500 mt-1">PT Sariling Aneka Energi &bull; Tangerang, Banten</p>
                    </div>

                    <div class="shrink-0">
                        @auth
                            @if(auth()->user()->isPelamar())
                                @if($sudahMelamar)
                                    <button disabled class="px-6 py-3.5 rounded-xl font-bold text-sm bg-slate-100 text-slate-400 cursor-not-allowed border border-slate-200">
                                        Sudah Dilamar
                                    </button>
                                @else
                                    <a href="{{ route('pelamar.lamar.create', $lowongan->id) }}"
                                       class="inline-flex items-center px-8 py-3.5 rounded-xl font-bold text-sm text-white bg-brand-600 hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/30 hover:shadow-xl hover:shadow-brand-600/40">
                                        Lamar Posisi Ini
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </a>
                                @endif
                            @else
                                <span class="text-xs font-semibold text-slate-400 bg-slate-100 px-4 py-2 rounded-xl">
                                    Login sebagai Pelamar untuk Melamar
                                </span>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3.5 rounded-xl font-bold text-sm text-white bg-brand-600 hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/25">
                                Masuk & Lamar Pekerjaan
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Job Quick Attributes -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-400 font-medium block">Kuota Dibutuhkan</span>
                        <span class="text-base font-bold text-slate-900">{{ $lowongan->kuota }} Orang</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-400 font-medium block">Tanggal Pembukaan</span>
                        <span class="text-base font-bold text-slate-900">{{ $lowongan->tanggal_buka->format('d M Y') }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 col-span-2 sm:col-span-1">
                        <span class="text-xs text-slate-400 font-medium block">Batas Pendaftaran</span>
                        <span class="text-base font-bold text-rose-600">{{ $lowongan->tanggal_tutup->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Job Description Section -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">Deskripsi Pekerjaan</h3>
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $lowongan->deskripsi }}</p>
                </div>

                <!-- Job Qualifications Section -->
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h3 class="text-lg font-bold text-slate-900">Kualifikasi & Persyaratan</h3>
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-slate-700 text-sm leading-relaxed whitespace-pre-line font-medium">
                        {{ $lowongan->kualifikasi }}
                    </div>
                </div>

                <!-- Bottom CTA -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-400">Pastikan kelengkapan berkas CV, Ijazah, dan KTP Anda siap sebelum melamar.</span>
                    @auth
                        @if(auth()->user()->isPelamar() && !$sudahMelamar)
                            <a href="{{ route('pelamar.lamar.create', $lowongan->id) }}" class="inline-flex items-center px-6 py-3 rounded-xl font-bold text-xs text-white bg-brand-600 hover:bg-brand-700">
                                Mulai Pendaftaran
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
