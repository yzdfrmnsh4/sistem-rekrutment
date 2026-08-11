<x-app-layout>
    <div class="min-h-[calc(100vh-16rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
        <div class="max-w-lg w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-slate-100">
            <!-- Header Logo & Title -->
            <div class="text-center">
                <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-brand-700 to-brand-600 items-center justify-center text-white shadow-lg shadow-brand-600/30 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Akun Pelamar</h2>
                <p class="mt-2 text-sm text-slate-500">
                    Isi data diri Anda untuk melamar pekerjaan di PT Sariling Aneka Energi
                </p>
            </div>

            <!-- Error Alerts -->
            @if ($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm space-y-1">
                    <div class="font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Terdapat kesalahan pengisian form
                    </div>
                    @foreach ($errors->all() as $error)
                        <p class="text-xs text-rose-700 pl-7">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Register Form -->
            <form class="mt-8 space-y-5" action="{{ route('register.process') }}" method="POST">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap (Sesuai KTP)</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                           placeholder="Contoh: Budi Pratama"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm transition-colors text-slate-900 bg-slate-50/50">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm transition-colors text-slate-900 bg-slate-50/50">
                    </div>
                    <div>
                        <label for="no_hp" class="block text-sm font-semibold text-slate-700 mb-1">No. HP / WhatsApp</label>
                        <input id="no_hp" name="no_hp" type="text" required value="{{ old('no_hp') }}"
                               placeholder="08123456789"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm transition-colors text-slate-900 bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Domisili Lengkap</label>
                    <textarea id="alamat" name="alamat" rows="2" required placeholder="Jl. Raya Serang No. 123, Cikupa, Tangerang..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm transition-colors text-slate-900 bg-slate-50/50">{{ old('alamat') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi</label>
                        <input id="password" name="password" type="password" required placeholder="Min. 8 karakter"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm transition-colors text-slate-900 bg-slate-50/50">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Sandi</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required placeholder="Ulangi kata sandi"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 focus:border-brand-600 text-sm transition-colors text-slate-900 bg-slate-50/50">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full flex justify-center py-3.5 px-4 rounded-xl text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/25 hover:shadow-xl hover:shadow-brand-600/35">
                        Daftar Akun Sekarang
                    </button>
                </div>

                <div class="text-center pt-4 border-t border-slate-100">
                    <p class="text-xs text-slate-500">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-700 ml-1">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
