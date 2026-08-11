<aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 min-h-screen border-r border-slate-800 shadow-xl">
    <!-- Sidebar Header -->
    <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-950/40">
        <a href="{{ url('/hrd/dashboard') }}" class="flex items-center space-x-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-bold shadow-md shadow-emerald-600/30">
                HRD
            </div>
            <div>
                <span class="font-bold text-white tracking-tight block text-sm">HRD EXECUTIVE</span>
                <span class="text-[10px] text-slate-400 font-medium tracking-wider uppercase">PT Sariling Aneka Energi</span>
            </div>
        </a>
    </div>

    <!-- Sidebar Menu Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        <div class="px-3 pb-2 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
            Executive Panel
        </div>

        <a href="{{ url('/hrd/dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('hrd/dashboard') ? 'bg-teal-600 text-white shadow-md shadow-teal-600/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Executive Overview
        </a>

        <a href="{{ url('/hrd/laporan') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('hrd/laporan*') ? 'bg-teal-600 text-white shadow-md shadow-teal-600/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Laporan Rekap PDF & Export
        </a>
    </nav>

    <!-- Sidebar Footer / Logout -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/40">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-xs font-semibold text-slate-200">
                    {{ strtoupper(substr(auth()->user()->name ?? 'HRD', 0, 2)) }}
                </div>
                <div class="truncate">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Manager HRD' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email ?? 'hrd@sariling.co.id' }}</p>
                </div>
            </div>
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" title="Logout" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
