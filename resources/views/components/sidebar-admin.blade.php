<aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 min-h-screen border-r border-slate-800 shadow-xl">
    <!-- Sidebar Header -->
    <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-950/40">
        <a href="{{ url('/admin/dashboard') }}" class="flex items-center space-x-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-600 to-brand-500 flex items-center justify-center text-white font-bold shadow-md shadow-brand-600/30">
                ADM
            </div>
            <div>
                <span class="font-bold text-white tracking-tight block text-sm">ADMIN PANEL</span>
                <span class="text-[10px] text-slate-400 font-medium tracking-wider uppercase">PT Sariling Aneka Energi</span>
            </div>
        </a>
    </div>

    <!-- Sidebar Menu Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
        <div class="px-3 pb-2 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
            Menu Utama
        </div>

        <a href="{{ url('/admin/dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('admin/dashboard') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            Dashboard Admin
        </a>

        <a href="{{ url('/admin/lowongan') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('admin/lowongan*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m46 0v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6m14 6v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6"></path>
            </svg>
            Kelola Lowongan
        </a>

        <div class="pt-4 px-3 pb-2 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
            Proses Rekrutmen
        </div>

        <a href="{{ url('/admin/pelamar') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('admin/pelamar*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Data Pelamar & CV
        </a>

        <a href="{{ url('/admin/jadwal') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('admin/jadwal*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Jadwal Seleksi & Tes
        </a>

        <a href="{{ url('/admin/hasil') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->is('admin/hasil*') ? 'bg-brand-600 text-white shadow-md shadow-brand-600/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Input Nilai & Keputusan
        </a>
    </nav>

    <!-- Sidebar Footer / Logout -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/40">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-xs font-semibold text-slate-200">
                    {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 2)) }}
                </div>
                <div class="truncate">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@sariling.co.id' }}</p>
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
