<x-admin-layout>
    <x-slot name="header">Input Nilai & Keputusan Akhir Seleksi</x-slot>

    <div class="space-y-6">
        <!-- Notification Alert -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                @foreach($errors->all() as $err)
                    <p>&bull; {{ $err }}</p>
                @endforeach
            </div>
        @endif

        <!-- Applicants Scoring Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Evaluasi Pelamar Tahap Lanjutan</h3>
                    <p class="text-xs text-slate-500">Input hasil skor tes, wawancara, dan penetapan status kelulusan pelamar</p>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($lamarans as $item)
                    <div class="p-6 hover:bg-slate-50/50 transition-colors" x-data="{ openForm: false }">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <span class="text-[10px] font-mono font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded">{{ $item->kode_pendaftaran }}</span>
                                <h4 class="text-base font-bold text-slate-900 mt-1">{{ $item->user->name }}</h4>
                                <p class="text-xs text-slate-500">Posisi: <strong>{{ $item->lowongan->judul_posisi }}</strong> | Email: {{ $item->user->email }}</p>
                            </div>

                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <span class="text-xs text-slate-400 block">Status Saat Ini</span>
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ str_replace('_', ' ', $item->status_lamaran) }}
                                    </span>
                                </div>
                                <button @click="openForm = !openForm" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-sm">
                                    <span x-text="openForm ? 'Tutup Form' : 'Input / Edit Nilai'">Input / Edit Nilai</span>
                                </button>
                            </div>
                        </div>

                        <!-- Current Score Preview if exists -->
                        @if($item->hasilSeleksi)
                            <div class="mt-3 p-3 rounded-xl bg-slate-50 border border-slate-100 grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                                <div><span class="text-slate-400">Nilai Tes:</span> <strong class="text-slate-800">{{ $item->hasilSeleksi->nilai_tes ?? '-' }}</strong></div>
                                <div><span class="text-slate-400">Nilai Wawancara:</span> <strong class="text-slate-800">{{ $item->hasilSeleksi->nilai_wawancara ?? '-' }}</strong></div>
                                <div><span class="text-slate-400">Keputusan:</span> <strong class="uppercase text-brand-700">{{ $item->hasilSeleksi->keputusan_akhir }}</strong></div>
                                <div><span class="text-slate-400">Pengumuman:</span> <strong class="text-slate-800">{{ $item->hasilSeleksi->tanggal_pengumuman->format('d M Y') }}</strong></div>
                            </div>
                        @endif

                        <!-- Scoring Accordion Form -->
                        <div x-show="openForm" x-collapse class="mt-4 pt-4 border-t border-slate-100">
                            <form action="{{ route('admin.nilai.store', $item->id) }}" method="POST" class="space-y-4 text-xs bg-slate-50 p-6 rounded-2xl border border-slate-200/80">
                                @csrf

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Nilai Tes Online (0 - 100)</label>
                                        <input type="number" step="0.01" min="0" max="100" name="nilai_tes" value="{{ old('nilai_tes', $item->hasilSeleksi->nilai_tes ?? '') }}" placeholder="Contoh: 85.50" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-white">
                                    </div>
                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Nilai Wawancara (0 - 100)</label>
                                        <input type="number" step="0.01" min="0" max="100" name="nilai_wawancara" value="{{ old('nilai_wawancara', $item->hasilSeleksi->nilai_wawancara ?? '') }}" placeholder="Contoh: 90.00" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-white">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Keputusan Akhir <span class="text-rose-500">*</span></label>
                                        <select name="keputusan_akhir" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-white font-bold text-slate-800">
                                            <option value="diterima" {{ old('keputusan_akhir', $item->hasilSeleksi->keputusan_akhir ?? '') == 'diterima' ? 'selected' : '' }}>DITERIMA (Lolos Seleksi)</option>
                                            <option value="ditolak" {{ old('keputusan_akhir', $item->hasilSeleksi->keputusan_akhir ?? '') == 'ditolak' ? 'selected' : '' }}>DITOLAK (Tidak Lolos)</option>
                                            <option value="cadangan" {{ old('keputusan_akhir', $item->hasilSeleksi->keputusan_akhir ?? '') == 'cadangan' ? 'selected' : '' }}>CADANGAN</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Tanggal Pengumuman Kelulusan <span class="text-rose-500">*</span></label>
                                        <input type="date" name="tanggal_pengumuman" required value="{{ old('tanggal_pengumuman', isset($item->hasilSeleksi->tanggal_pengumuman) ? $item->hasilSeleksi->tanggal_pengumuman->format('Y-m-d') : date('Y-m-d')) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-white">
                                    </div>
                                </div>

                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Catatan Evaluasi Tim HRD / User</label>
                                    <textarea name="catatan_evaluasi" rows="2" placeholder="Catatan kelebihan/kekurangan pelamar selama proses wawancara..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-white">{{ old('catatan_evaluasi', $item->hasilSeleksi->catatan_evaluasi ?? '') }}</textarea>
                                </div>

                                <div class="flex justify-end space-x-2 pt-2">
                                    <button type="button" @click="openForm = false" class="px-4 py-2 text-slate-600 hover:bg-slate-200 rounded-xl font-bold">Batal</button>
                                    <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-sm">Simpan Keputusan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-400 text-sm">
                        Belum ada pelamar yang siap dievaluasi. Pastikan pelamar telah lolos berkas administrasi.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>
