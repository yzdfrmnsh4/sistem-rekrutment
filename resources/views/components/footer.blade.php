<footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <!-- Col 1: Profile -->
            <div class="space-y-4 md:col-span-2">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-brand-600 flex items-center justify-center text-white font-bold">
                        SAE
                    </div>
                    <span class="text-lg font-bold text-white tracking-tight">PT Sariling Aneka Energi</span>
                </div>
                <p class="text-sm text-slate-400 max-w-md leading-relaxed">
                    Penyedia solusi genset, kelistrikan, dan energi terpercaya di Indonesia. Kami berkomitmen menciptakan lingkungan kerja profesional dan berkembang bagi talenta-talenta terbaik bangsa.
                </p>
            </div>

            <!-- Col 2: Navigasi Cepat -->
            <div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Navigasi</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-brand-400 transition-colors">Beranda</a></li>
                    <li><a href="{{ url('/#lowongan') }}" class="hover:text-brand-400 transition-colors">Lowongan Pekerjaan</a></li>
                    <li><a href="{{ url('/#tentang') }}" class="hover:text-brand-400 transition-colors">Tentang Perusahaan</a></li>
                    <li><a href="{{ url('/login') }}" class="hover:text-brand-400 transition-colors">Portal Masuk Pelamar</a></li>
                </ul>
            </div>

            <!-- Col 3: Kontak & Lokasi -->
            <div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Kantor Pusat</h4>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Jl. Raya Serang Km 14.5 No. 88, Cikupa, Tangerang, Banten 15710
                </p>
                <div class="mt-3 text-sm text-slate-400 space-y-1">
                    <p>Email: recruitment@sariling.co.id</p>
                    <p>Telp: (021) 5960-xxxx</p>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} PT Sariling Aneka Energi Tangerang. All rights reserved.</p>
            <p class="mt-2 md:mt-0">Sistem Informasi Rekrutmen Karyawan Berbasis Web</p>
        </div>
    </div>
</footer>
