<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-[calc(100vh-16rem)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- User Welcome Banner -->
            <div class="bg-gradient-to-r from-brand-700 via-brand-600 to-sky-600 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider mb-2">Portal Pelamar</span>
                    <h1 class="text-3xl font-extrabold tracking-tight">Selamat Datang, {{ $user->name }}!</h1>
                    <p class="text-brand-100 text-sm mt-1">Email: {{ $user->email }} | No. HP: {{ $user->no_hp ?? '-' }}</p>
                </div>
                <a href="{{ url('/#lowongan') }}" class="px-6 py-3 rounded-xl bg-white text-brand-700 hover:bg-brand-50 font-bold text-sm transition-all shadow-md">
                    Cari Lowongan Baru
                </a>
            </div>

            <!-- Status Lamaran List -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight">Riwayat Lamaran Saya</h2>
                        <p class="text-xs text-slate-500">Pantau perkembangan status pendaftaran dan jadwal seleksi Anda</p>
                    </div>
                </div>

                @if($lamarans->isEmpty())
                    <div class="text-center py-12 space-y-4">
                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Belum Ada Lamaran Terdaftar</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">Anda belum mendaftar pada posisi lowongan pekerjaan apapun. Silakan pilih lowongan di halaman utama.</p>
                        <a href="{{ url('/#lowongan') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                            Lihat Lowongan Pekerjaan
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach($lamarans as $lamaran)
                            <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <span class="text-xs font-mono font-bold text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded">{{ $lamaran->kode_pendaftaran }}</span>
                                    <h4 class="text-lg font-bold text-slate-900 mt-1">{{ $lamaran->lowongan->judul_posisi }}</h4>
                                    <p class="text-xs text-slate-500">Tanggal Daftar: {{ $lamaran->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div>
                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                        {{ str_replace('_', ' ', $lamaran->status_lamaran) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
