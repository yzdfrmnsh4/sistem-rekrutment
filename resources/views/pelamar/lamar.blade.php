<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-[calc(100vh-16rem)]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Navigation Back -->
            <div>
                <a href="{{ route('lowongan.detail', $lowongan->slug) }}" class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Detail Lowongan
                </a>
            </div>

            <!-- Header Card -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xl space-y-6">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-brand-50 text-brand-700 border border-brand-100 mb-2">Formulir Pendaftaran</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Melamar Posisi: {{ $lowongan->judul_posisi }}</h1>
                    <p class="text-xs text-slate-500 mt-1">Departemen: {{ $lowongan->departemen }} &bull; PT Sariling Aneka Energi</p>
                </div>

                <!-- Validation Error Alert -->
                @if ($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm space-y-1">
                        <div class="font-bold flex items-center">
                            <svg class="w-5 h-5 mr-2 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Terdapat kesalahan unggah berkas
                        </div>
                        @foreach ($errors->all() as $error)
                            <p class="text-xs text-rose-700 pl-7">&bull; {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Upload Form -->
                <form action="{{ route('pelamar.lamar.store', $lowongan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 pt-4 border-t border-slate-100">
                    @csrf

                    <!-- Section Applicant Info Confirmation -->
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2 text-xs text-slate-600">
                        <p class="font-bold text-slate-800 text-sm">Informasi Pelamar</p>
                        <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>No. HP:</strong> {{ auth()->user()->no_hp ?? '-' }}</p>
                    </div>

                    <!-- Upload Field 1: CV (PDF Max 2MB) -->
                    <div class="space-y-2">
                        <label for="berkas_cv" class="block text-sm font-bold text-slate-800">
                            Curriculum Vitae (CV) Terkini <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500">Wajib format PDF, ukuran maksimal 2MB.</p>
                        <input id="berkas_cv" name="berkas_cv" type="file" accept=".pdf" required
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 cursor-pointer border border-slate-200 rounded-xl bg-slate-50/50 p-2">
                    </div>

                    <!-- Upload Field 2: Ijazah (PDF Max 2MB) -->
                    <div class="space-y-2">
                        <label for="berkas_ijazah" class="block text-sm font-bold text-slate-800">
                            Ijazah & Transkrip Nilai <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500">Wajib format PDF, ukuran maksimal 2MB.</p>
                        <input id="berkas_ijazah" name="berkas_ijazah" type="file" accept=".pdf" required
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 cursor-pointer border border-slate-200 rounded-xl bg-slate-50/50 p-2">
                    </div>

                    <!-- Upload Field 3: KTP (JPG/PNG/PDF Max 2MB) -->
                    <div class="space-y-2">
                        <label for="berkas_ktp" class="block text-sm font-bold text-slate-800">
                            Scan / Foto KTP <span class="text-rose-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500">Format gambar (JPG, PNG) atau PDF, ukuran maksimal 2MB.</p>
                        <input id="berkas_ktp" name="berkas_ktp" type="file" accept=".jpg,.jpeg,.png,.pdf" required
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 cursor-pointer border border-slate-200 rounded-xl bg-slate-50/50 p-2">
                    </div>

                    <!-- Upload Field 4: Pendukung (PDF Max 5MB, Optional) -->
                    <div class="space-y-2">
                        <label for="berkas_pendukung" class="block text-sm font-bold text-slate-800">
                            Dokumen Pendukung / Sertifikat <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <p class="text-xs text-slate-500">Sertifikat keahlian, paklaring, atau TOEFL (PDF, max 5MB).</p>
                        <input id="berkas_pendukung" name="berkas_pendukung" type="file" accept=".pdf"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer border border-slate-200 rounded-xl bg-slate-50/50 p-2">
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="{{ route('lowongan.detail', $lowongan->slug) }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3.5 rounded-xl font-bold text-sm text-white bg-brand-600 hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/30">
                            Kirim Berkas Lamaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
