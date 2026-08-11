<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-[calc(100vh-16rem)]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Navigation Back -->
            <div>
                <a href="{{ route('pelamar.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-brand-600 transition-colors">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Dashboard Pelamar
                </a>
            </div>

            <!-- Detail Lamaran Card -->
            <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/80 shadow-xl space-y-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                    <div>
                        <span class="text-xs font-mono font-bold text-brand-600 bg-brand-50 px-3 py-1 rounded-md border border-brand-100">
                            {{ $lamaran->kode_pendaftaran }}
                        </span>
                        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-2">{{ $lamaran->lowongan->judul_posisi }}</h1>
                        <p class="text-xs text-slate-500 mt-1">Tanggal Pendaftaran: {{ $lamaran->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <span class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                            {{ str_replace('_', ' ', $lamaran->status_lamaran) }}
                        </span>
                    </div>
                </div>

                <!-- Admin Notes if exists -->
                @if($lamaran->catatan_admin)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-sm space-y-1">
                        <span class="font-bold text-slate-800 text-xs block">Catatan Panitia Rekrutmen / Admin:</span>
                        <p class="text-slate-600 text-xs italic">{{ $lamaran->catatan_admin }}</p>
                    </div>
                @endif

                <!-- Uploaded Files List -->
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-slate-900">Berkas Terunggah</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xs">PDF</div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Curriculum Vitae (CV)</p>
                                    <p class="text-[10px] text-slate-400">Berkas PDF</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $lamaran->path_cv) }}" target="_blank" class="text-xs font-bold text-brand-600 hover:text-brand-700">Lihat</a>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xs">PDF</div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Ijazah & Transkrip</p>
                                    <p class="text-[10px] text-slate-400">Berkas PDF</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $lamaran->path_ijazah) }}" target="_blank" class="text-xs font-bold text-brand-600 hover:text-brand-700">Lihat</a>
                        </div>

                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs">KTP</div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Scan KTP</p>
                                    <p class="text-[10px] text-slate-400">File KTP</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $lamaran->path_ktp) }}" target="_blank" class="text-xs font-bold text-brand-600 hover:text-brand-700">Lihat</a>
                        </div>

                        @if($lamaran->path_pendukung)
                            <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-bold text-xs">DOC</div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">Dokumen Pendukung</p>
                                        <p class="text-[10px] text-slate-400">Sertifikat / Paklaring</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $lamaran->path_pendukung) }}" target="_blank" class="text-xs font-bold text-brand-600 hover:text-brand-700">Lihat</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Schedule / Result Info if available -->
                @if($lamaran->jadwalSeleksi->count() > 0)
                    <div class="pt-6 border-t border-slate-100 space-y-4">
                        <h3 class="text-base font-bold text-slate-900">Jadwal Seleksi Saya</h3>
                        <div class="space-y-3">
                            @foreach($lamaran->jadwalSeleksi as $jadwal)
                                <div class="p-4 rounded-2xl border border-brand-100 bg-brand-50/50 space-y-1">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-bold uppercase tracking-wider text-brand-700">Tahap: {{ str_replace('_', ' ', $jadwal->tahap_seleksi) }}</span>
                                        <span class="text-xs font-semibold text-slate-600">{{ $jadwal->tanggal_waktu->format('d M Y, H:i') }} WIB</span>
                                    </div>
                                    <p class="text-xs text-slate-700"><strong>Lokasi / Link:</strong> {{ $jadwal->lokasi_atau_link }}</p>
                                    @if($jadwal->instruksi_tambahan)
                                        <p class="text-xs text-slate-500"><strong>Instruksi:</strong> {{ $jadwal->instruksi_tambahan }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
