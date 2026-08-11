<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-[calc(100vh-16rem)]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Navigation Back -->
            <div>
                <a href="{{ route('pelamar.dashboard') }}" class="inline-flex items-center text-xs font-bold text-slate-600 hover:text-brand-600 transition-colors bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Dashboard Pelamar
                </a>
            </div>

            <!-- Detail Header Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xl space-y-8">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-mono font-bold text-brand-600 bg-brand-50 px-3 py-1 rounded-md border border-brand-100">
                                {{ $lamaran->kode_pendaftaran }}
                            </span>
                            <span class="text-xs text-slate-400">Pendaftaran: {{ $lamaran->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $lamaran->lowongan->judul_posisi }}</h1>
                        <p class="text-xs font-semibold text-slate-500">Departemen: {{ $lamaran->lowongan->departemen }} | Kuota: {{ $lamaran->lowongan->kuota }} Posisi</p>
                    </div>

                    <div>
                        @php
                            $statusClass = [
                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'lolos_administrasi' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'tidak_lolos' => 'bg-rose-50 text-rose-700 border-rose-200',
                                'jadwal_tes' => 'bg-sky-50 text-sky-700 border-sky-200',
                                'diterima' => 'bg-teal-50 text-teal-700 border-teal-200',
                                'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                            ][$lamaran->status_lamaran] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                        @endphp
                        <span class="px-4 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wider border {{ $statusClass }}">
                            {{ str_replace('_', ' ', $lamaran->status_lamaran) }}
                        </span>
                    </div>
                </div>

                <!-- PROGRESS TIMELINE TRACKER (4 STAGES) -->
                <div class="space-y-4 pt-2">
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Status Tahapan Rekrutmen</h3>
                    
                    @php
                        $stg = $lamaran->status_lamaran;
                        $step1 = true; // Pendaftaran selalu completed
                        $step2 = in_array($stg, ['lolos_administrasi', 'jadwal_tes', 'diterima', 'ditolak']);
                        $step3 = in_array($stg, ['jadwal_tes', 'diterima', 'ditolak']);
                        $step4 = in_array($stg, ['diterima', 'ditolak']);
                    @endphp

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <!-- Step 1 -->
                        <div class="p-3.5 rounded-2xl border bg-emerald-50/60 border-emerald-200 space-y-1">
                            <div class="flex items-center justify-between text-xs font-bold text-emerald-800">
                                <span>1. Berkas Masuk</span>
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-[10px] text-emerald-600">Dokumen terverifikasi sistem</p>
                        </div>

                        <!-- Step 2 -->
                        <div class="p-3.5 rounded-2xl border {{ $step2 ? 'bg-emerald-50/60 border-emerald-200 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-400' }} space-y-1">
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span>2. Verifikasi Admin</span>
                                @if($step2)
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                            </div>
                            <p class="text-[10px]">{{ $step2 ? 'Lolos seleksi berkas' : 'Menunggu review admin' }}</p>
                        </div>

                        <!-- Step 3 -->
                        <div class="p-3.5 rounded-2xl border {{ $step3 ? 'bg-sky-50/80 border-sky-200 text-sky-800' : 'bg-slate-50 border-slate-200 text-slate-400' }} space-y-1">
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span>3. Tes & Wawancara</span>
                                @if($step3)
                                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            <p class="text-[10px]">{{ $step3 ? 'Jadwal seleksi aktif' : 'Belum dijadwalkan' }}</p>
                        </div>

                        <!-- Step 4 -->
                        <div class="p-3.5 rounded-2xl border {{ $step4 ? ($stg == 'diterima' ? 'bg-teal-50 border-teal-200 text-teal-800' : 'bg-rose-50 border-rose-200 text-rose-800') : 'bg-slate-50 border-slate-200 text-slate-400' }} space-y-1">
                            <div class="flex items-center justify-between text-xs font-bold">
                                <span>4. Hasil Akhir</span>
                                @if($step4)
                                    <svg class="w-4 h-4 {{ $stg == 'diterima' ? 'text-teal-600' : 'text-rose-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <p class="text-[10px]">{{ $step4 ? str_replace('_', ' ', strtoupper($stg)) : 'Belum diumumkan' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Admin Notes / Feedback -->
                @if($lamaran->catatan_admin)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-1">
                        <span class="font-bold text-slate-800 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Catatan Tim Rekrutmen / Admin:
                        </span>
                        <p class="text-slate-600 leading-relaxed italic pl-5">{{ $lamaran->catatan_admin }}</p>
                    </div>
                @endif

                <!-- Uploaded Documents -->
                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Berkas Terunggah Saya</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/60 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xs">PDF</div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Curriculum Vitae (CV)</p>
                                    <p class="text-[10px] text-slate-400">Berkas Dokumen PDF</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $lamaran->path_cv) }}" target="_blank" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                                Lihat / Unduh
                            </a>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/60 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xs">PDF</div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Ijazah & Transkrip</p>
                                    <p class="text-[10px] text-slate-400">Berkas Dokumen PDF</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $lamaran->path_ijazah) }}" target="_blank" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                                Lihat / Unduh
                            </a>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/60 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs">KTP</div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Scan KTP</p>
                                    <p class="text-[10px] text-slate-400">File Identitas</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $lamaran->path_ktp) }}" target="_blank" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                                Lihat / Unduh
                            </a>
                        </div>

                        @if($lamaran->path_pendukung)
                            <div class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50/60 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-xs">DOC</div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">Dokumen Pendukung</p>
                                        <p class="text-[10px] text-slate-400">Sertifikat / Paklaring</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $lamaran->path_pendukung) }}" target="_blank" class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                                    Lihat / Unduh
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Selection Schedule Info if Scheduled -->
                @if($lamaran->jadwalSeleksi->count() > 0)
                    <div class="pt-6 border-t border-slate-100 space-y-4">
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Jadwal Seleksi & Wawancara</h3>
                        <div class="space-y-3">
                            @foreach($lamaran->jadwalSeleksi as $jadwal)
                                <div class="p-5 rounded-2xl border border-sky-200 bg-sky-50/60 space-y-2">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-1 border-b border-sky-200/60 pb-2">
                                        <span class="text-xs font-bold uppercase tracking-wider text-sky-800">
                                            Tahap: {{ str_replace('_', ' ', $jadwal->tahap_seleksi) }}
                                        </span>
                                        <span class="text-xs font-extrabold text-slate-800 bg-white px-3 py-1 rounded-lg border border-sky-100 shadow-sm">
                                            📅 {{ $jadwal->tanggal_waktu->format('d M Y, H:i') }} WIB
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-800"><strong>📍 Lokasi / Meeting Link:</strong> {{ $jadwal->lokasi_atau_link }}</p>
                                    @if($jadwal->instruksi_tambahan)
                                        <p class="text-xs text-slate-600 bg-white/70 p-2.5 rounded-xl border border-sky-100">
                                            <strong>Instruksi Tambahan:</strong> {{ $jadwal->instruksi_tambahan }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Final Decision & Evaluation Info if Available -->
                @if($lamaran->hasilSeleksi)
                    <div class="pt-6 border-t border-slate-100 space-y-4">
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Hasil Seleksi & Keputusan Akhir</h3>
                        <div class="p-5 rounded-2xl border {{ $lamaran->hasilSeleksi->keputusan_akhir == 'diterima' ? 'border-teal-200 bg-teal-50/70' : 'border-rose-200 bg-rose-50/70' }} space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700">Pengumuman Resmi Panitia:</span>
                                <span class="px-3 py-1 rounded-xl text-xs font-extrabold uppercase {{ $lamaran->hasilSeleksi->keputusan_akhir == 'diterima' ? 'bg-teal-600 text-white' : 'bg-rose-600 text-white' }}">
                                    {{ strtoupper($lamaran->hasilSeleksi->keputusan_akhir) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-center bg-white p-3 rounded-xl border border-slate-200/60">
                                <div>
                                    <span class="block text-[10px] text-slate-400 font-semibold uppercase">Nilai Tes</span>
                                    <span class="text-lg font-extrabold text-slate-900">{{ number_format($lamaran->hasilSeleksi->nilai_tes, 1) }}</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] text-slate-400 font-semibold uppercase">Nilai Wawancara</span>
                                    <span class="text-lg font-extrabold text-slate-900">{{ number_format($lamaran->hasilSeleksi->nilai_wawancara, 1) }}</span>
                                </div>
                            </div>

                            @if($lamaran->hasilSeleksi->catatan_evaluasi)
                                <p class="text-xs text-slate-700 bg-white/80 p-3 rounded-xl border border-slate-200/60">
                                    <strong>Evaluasi Tim HRD/User:</strong> {{ $lamaran->hasilSeleksi->catatan_evaluasi }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
