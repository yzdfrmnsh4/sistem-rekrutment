<x-admin-layout>
    <x-slot name="header">Review Berkas Pelamar</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <div>
            <a href="{{ route('admin.pelamar.index') }}" class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-slate-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Verifikasi Pelamar
            </a>
        </div>

        <!-- Notification Alert -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Applicant Profile & Uploaded Files -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Profile Card -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <span class="text-xs font-mono font-bold text-brand-600 bg-brand-50 px-3 py-1 rounded-md border border-brand-100">
                                {{ $lamaran->kode_pendaftaran }}
                            </span>
                            <h2 class="text-2xl font-extrabold text-slate-900 mt-2">{{ $lamaran->user->name }}</h2>
                            <p class="text-xs text-slate-500 mt-1">Posisi Dilamar: <strong>{{ $lamaran->lowongan->judul_posisi }}</strong></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <span class="text-slate-400 block mb-0.5">Alamat Email</span>
                            <span class="font-bold text-slate-800">{{ $lamaran->user->email }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <span class="text-slate-400 block mb-0.5">No. HP / WhatsApp</span>
                            <span class="font-bold text-slate-800">{{ $lamaran->user->no_hp ?? '-' }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl col-span-2">
                            <span class="text-slate-400 block mb-0.5">Alamat Domisili</span>
                            <span class="font-semibold text-slate-800">{{ $lamaran->user->alamat ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Documents List & Preview -->
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-4">Dokumen Pelamar Terunggah</h3>

                    <div class="space-y-4">
                        <!-- CV File -->
                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xs">PDF</div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900">Curriculum Vitae (CV)</h4>
                                    <p class="text-[10px] text-slate-400">Berkas Wajib Pelamar</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $lamaran->path_cv) }}" target="_blank" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-sm">
                                Buka Dokumen CV
                            </a>
                        </div>

                        <!-- Ijazah File -->
                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xs">PDF</div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900">Ijazah & Transkrip Nilai</h4>
                                    <p class="text-[10px] text-slate-400">Berkas Wajib Pelamar</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $lamaran->path_ijazah) }}" target="_blank" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-sm">
                                Buka Dokumen Ijazah
                            </a>
                        </div>

                        <!-- KTP File -->
                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-xs">KTP</div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900">Scan KTP</h4>
                                    <p class="text-[10px] text-slate-400">Identitas Kependudukan</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $lamaran->path_ktp) }}" target="_blank" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-sm">
                                Buka Dokumen KTP
                            </a>
                        </div>

                        <!-- Pendukung File -->
                        @if($lamaran->path_pendukung)
                            <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-xs">DOC</div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900">Dokumen Pendukung / Sertifikat</h4>
                                        <p class="text-[10px] text-slate-400">Dokumen Tambahan Pelamar</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $lamaran->path_pendukung) }}" target="_blank" class="px-4 py-2 bg-slate-700 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-sm">
                                    Buka Dokumen Pendukung
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Verification Status Update Form -->
            <div class="space-y-6">
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6 sticky top-6">
                    <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-4">Keputusan Verifikasi Admin</h3>

                    <form action="{{ route('admin.pelamar.updateStatus', $lamaran->id) }}" method="POST" class="space-y-4 text-xs">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="status_lamaran" class="block font-bold text-slate-700 mb-1">Status Verifikasi Berkas</label>
                            <select id="status_lamaran" name="status_lamaran" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900 font-semibold">
                                <option value="pending" {{ $lamaran->status_lamaran == 'pending' ? 'selected' : '' }}>Pending (Baru Daftar)</option>
                                <option value="seleksi_berkas" {{ $lamaran->status_lamaran == 'seleksi_berkas' ? 'selected' : '' }}>Dalam Ditinjau Admin</option>
                                <option value="lolos_administrasi" {{ $lamaran->status_lamaran == 'lolos_administrasi' ? 'selected' : '' }}>Lolos Administrasi</option>
                                <option value="ditolak" {{ $lamaran->status_lamaran == 'ditolak' ? 'selected' : '' }}>Ditolak / Tidak Lolos</option>
                            </select>
                        </div>

                        <div>
                            <label for="catatan_admin" class="block font-bold text-slate-700 mb-1">Catatan Evaluasi / Alasan Penolakan</label>
                            <textarea id="catatan_admin" name="catatan_admin" rows="4" placeholder="Tuliskan catatan internal atau alasan penolakan jika berkas tidak sesuai..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">{{ old('catatan_admin', $lamaran->catatan_admin) }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-md transition-all text-xs">
                            Simpan Hasil Verifikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
