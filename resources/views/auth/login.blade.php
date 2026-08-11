<x-app-layout>
    <div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
        <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-slate-100">
            <!-- Header Logo & Title -->
            <div class="text-center">
                <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-brand-700 to-brand-600 items-center justify-center text-white shadow-lg shadow-brand-600/30 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Masuk ke Akun Anda</h2>
                <p class="mt-2 text-sm text-slate-500">
                    Sistem Penerimaan Karyawan PT Sariling Aneka Energi
                </p>
            </div>

            <!-- Error Alerts -->
            @if ($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm space-y-1">
                    <div class="font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Gagal Masuk
                    </div>
                    @foreach ($errors->all() as $error)
                        <p class="text-xs text-rose-700 pl-7">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            <form class="mt-8 space-y-6" action="{{ route('login.process') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm transition-colors text-slate-900 bg-slate-50/50">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               placeholder="••••••••"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm transition-colors text-slate-900 bg-slate-50/50">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-slate-300 rounded">
                        <label for="remember" class="ml-2 block text-xs font-medium text-slate-600">
                            Ingat saya di perangkat ini
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 rounded-xl text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/25 hover:shadow-xl hover:shadow-brand-600/35">
                        Masuk Sekarang
                    </button>
                </div>

                <div class="text-center pt-4 border-t border-slate-100">
                    <p class="text-xs text-slate-500">
                        Belum memiliki akun pelamar?
                        <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:text-brand-700 ml-1">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
