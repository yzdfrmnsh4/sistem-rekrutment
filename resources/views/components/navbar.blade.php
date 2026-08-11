<nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <!-- Brand Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-700 to-brand-600 flex items-center justify-center text-white shadow-md shadow-brand-600/20 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m46 0v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6m14 6v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight text-slate-900 block leading-tight">PT Sariling Aneka Energi</span>
                        <span class="text-xs font-semibold tracking-wider text-brand-600 uppercase block">E-Recruitment Portal</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links (Desktop) -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ url('/') }}" class="text-sm font-medium text-slate-700 hover:text-brand-600 transition-colors">Beranda</a>
                <a href="{{ url('/#lowongan') }}" class="text-sm font-medium text-slate-700 hover:text-brand-600 transition-colors">Lowongan Kerja</a>
                <a href="{{ url('/#tentang') }}" class="text-sm font-medium text-slate-700 hover:text-brand-600 transition-colors">Tentang Kami</a>
            </div>

            <!-- Auth Buttons (Desktop) -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? url('/admin/dashboard') : (auth()->user()->role === 'hrd' ? url('/hrd/dashboard') : url('/pelamar/dashboard')) }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 transition-all shadow-md shadow-brand-600/20 hover:shadow-lg hover:shadow-brand-600/30">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ url('/login') }}" class="text-sm font-semibold text-slate-700 hover:text-brand-600 px-4 py-2 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ url('/register') }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 transition-all shadow-md shadow-brand-600/20 hover:shadow-lg hover:shadow-brand-600/30">
                        Daftar Akun
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                    <svg class="w-6 h-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="w-6 h-6" x-show="mobileMenuOpen" x-cloak fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-t border-slate-100 bg-white px-4 pt-3 pb-6 space-y-3">
        <a href="{{ url('/') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-600">Beranda</a>
        <a href="{{ url('/#lowongan') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-600">Lowongan Kerja</a>
        <a href="{{ url('/#tentang') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-600">Tentang Kami</a>
        <div class="pt-4 border-t border-slate-100 flex flex-col space-y-2">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? url('/admin/dashboard') : (auth()->user()->role === 'hrd' ? url('/hrd/dashboard') : url('/pelamar/dashboard')) }}"
                   class="w-full text-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700">
                    Dashboard
                </a>
            @else
                <a href="{{ url('/login') }}" class="w-full text-center px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 border border-slate-200 hover:bg-slate-50">
                    Masuk
                </a>
                <a href="{{ url('/register') }}" class="w-full text-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700">
                    Daftar Akun
                </a>
            @endauth
        </div>
    </div>
</nav>
