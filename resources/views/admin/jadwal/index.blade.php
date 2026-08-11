<x-admin-layout>
    <x-slot name="header">Penjadwalan Seleksi & Wawancara</x-slot>

    <div class="space-y-8">
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Form Penetapan Jadwal Baru -->
            <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-4">Atur Jadwal Pelamar Baru</h3>

                <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf

                    <div>
                        <label for="lamaran_id" class="block font-bold text-slate-700 mb-1">Pilih Pelamar (Lolos Berkas) <span class="text-rose-500">*</span></label>
                        <select id="lamaran_id" name="lamaran_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">
                            <option value="">-- Pilih Pelamar --</option>
                            @foreach($lamaransLolos as $l)
                                <option value="{{ $l->id }}">
                                    {{ $l->kode_pendaftaran }} - {{ $l->user->name }} ({{ $l->lowongan->judul_posisi }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="tahap_seleksi" class="block font-bold text-slate-700 mb-1">Tahap Seleksi <span class="text-rose-500">*</span></label>
                        <select id="tahap_seleksi" name="tahap_seleksi" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">
                            <option value="tes_online">Tes Online / Psikotes</option>
                            <option value="wawancara_hrd">Wawancara HRD</option>
                            <option value="wawancara_user">Wawancara User / Teknikal</option>
                            <option value="mcu">Medical Check Up (MCU)</option>
                        </select>
                    </div>

                    <div>
                        <label for="tanggal_waktu" class="block font-bold text-slate-700 mb-1">Tanggal & Waktu Execution <span class="text-rose-500">*</span></label>
                        <input id="tanggal_waktu" name="tanggal_waktu" type="datetime-local" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">
                    </div>

                    <div>
                        <label for="lokasi_atau_link" class="block font-bold text-slate-700 mb-1">Lokasi / Link Meeting <span class="text-rose-500">*</span></label>
                        <input id="lokasi_atau_link" name="lokasi_atau_link" type="text" required placeholder="Ruang Rapat Utama A / Link Google Meet / Zoom..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">
                    </div>

                    <div>
                        <label for="instruksi_tambahan" class="block font-bold text-slate-700 mb-1">Instruksi Tambahan Pelamar</label>
                        <textarea id="instruksi_tambahan" name="instruksi_tambahan" rows="3" placeholder="Pakaian kemeja putih, membawa dokumen cetak..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-md transition-all text-xs">
                        Tetapkan & Kirim Jadwal
                    </button>
                </form>
            </div>

            <!-- Right Column: List Jadwal Aktif -->
            <div class="lg:col-span-2 bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-4">Daftar Jadwal Seleksi Terjadwal</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="py-3 px-4">Pelamar & Posisi</th>
                                <th class="py-3 px-4">Tahap</th>
                                <th class="py-3 px-4">Tanggal & Waktu</th>
                                <th class="py-3 px-4">Lokasi / Link</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-600 font-medium">
                            @forelse($jadwals as $item)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4">
                                        <div class="font-bold text-slate-900">{{ $item->lamaran->user->name }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $item->lamaran->lowongan->judul_posisi }}</div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-1 bg-brand-50 text-brand-700 font-bold rounded text-[10px] uppercase">
                                            {{ str_replace('_', ' ', $item->tahap_seleksi) }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-800">
                                        {{ $item->tanggal_waktu->format('d M Y, H:i') }} WIB
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 truncate max-w-[150px]">
                                        {{ $item->lokasi_atau_link }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <form action="{{ route('admin.jadwal.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold text-xs">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400">Belum ada jadwal seleksi yang ditetapkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
