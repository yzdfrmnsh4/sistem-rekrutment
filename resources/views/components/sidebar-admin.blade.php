<aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between hidden md:flex min-h-screen">
    <div>
        <!-- Brand Logo -->
        <div class="h-20 flex items-center px-6 border-b border-slate-800">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-brand-600 flex items-center justify-center text-white font-extrabold text-lg shadow-md">
                    S
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-white text-sm tracking-wider uppercase">SARILING</span>
                    <span class="text-[10px] text-brand-400 font-semibold uppercase tracking-widest">Admin Panel</span>
                </div>
            </a>
        </div>

        <!-- Navigation Menu -->
        <div class="px-4 py-6 space-y-1 text-xs font-semibold">
            <div class="px-3 pb-2 text-[10px] uppercase font-bold text-slate-500 tracking-wider">Main Nav</div>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard Summary
            </a>

            <a href="{{ route('admin.lowongan.index') }}" class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.lowongan.*') ? 'bg-brand-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Kelola Lowongan
            </a>

            <div class="px-3 pt-4 pb-2 text-[10px] uppercase font-bold text-slate-500 tracking-wider">Rekrutmen & Verifikasi</div>

            <a href="{{ route('admin.pelamar.index') }}" class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.pelamar.*') ? 'bg-brand-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Verifikasi Berkas
            </a>

            <a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.jadwal.*') ? 'bg-brand-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Penjadwalan Seleksi
            </a>

            <a href="{{ route('admin.nilai.index') }}" class="flex items-center px-3 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.nilai.*') ? 'bg-brand-600 text-white font-bold' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Input Nilai & Keputusan
            </a>
        </div>
    </div>

    <!-- User Profile / Logout Foot -->
    <div class="p-4 border-t border-slate-800">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center font-bold text-white text-xs">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-white truncate max-w-[100px]">{{ auth()->user()->name ?? 'Administrator' }}</span>
                    <span class="text-[10px] text-slate-400">Admin</span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 transition-colors" title="Logout">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
