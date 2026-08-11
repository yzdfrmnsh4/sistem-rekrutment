<x-admin-layout>
    <x-slot name="header">Edit Lowongan Pekerjaan</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <a href="{{ route('admin.lowongan.index') }}" class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-slate-800">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Lowongan
            </a>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
            <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4">Edit Form: {{ $lowongan->judul_posisi }}</h2>

            @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    @foreach($errors->all() as $err)
                        <p>&bull; {{ $err }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.lowongan.update', $lowongan->id) }}" method="POST" class="space-y-5 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label for="judul_posisi" class="block font-bold text-slate-700 mb-1">Judul Posisi / Jabatan <span class="text-rose-500">*</span></label>
                    <input id="judul_posisi" name="judul_posisi" type="text" required value="{{ old('judul_posisi', $lowongan->judul_posisi) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="departemen" class="block font-bold text-slate-700 mb-1">Departemen <span class="text-rose-500">*</span></label>
                        <input id="departemen" name="departemen" type="text" required value="{{ old('departemen', $lowongan->departemen) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">
                    </div>
                    <div>
                        <label for="kuota" class="block font-bold text-slate-700 mb-1">Kuota Dibutuhkan <span class="text-rose-500">*</span></label>
                        <input id="kuota" name="kuota" type="number" min="1" required value="{{ old('kuota', $lowongan->kuota) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block font-bold text-slate-700 mb-1">Deskripsi Pekerjaan <span class="text-rose-500">*</span></label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                </div>

                <div>
                    <label for="kualifikasi" class="block font-bold text-slate-700 mb-1">Kualifikasi & Persyaratan <span class="text-rose-500">*</span></label>
                    <textarea id="kualifikasi" name="kualifikasi" rows="4" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">{{ old('kualifikasi', $lowongan->kualifikasi) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="status" class="block font-bold text-slate-700 mb-1">Status Publikasi <span class="text-rose-500">*</span></label>
                        <select id="status" name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">
                            <option value="draft" {{ old('status', $lowongan->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $lowongan->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="closed" {{ old('status', $lowongan->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div>
                        <label for="tanggal_buka" class="block font-bold text-slate-700 mb-1">Tanggal Pembukaan <span class="text-rose-500">*</span></label>
                        <input id="tanggal_buka" name="tanggal_buka" type="date" required value="{{ old('tanggal_buka', $lowongan->tanggal_buka->format('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">
                    </div>
                    <div>
                        <label for="tanggal_tutup" class="block font-bold text-slate-700 mb-1">Tanggal Penutupan <span class="text-rose-500">*</span></label>
                        <input id="tanggal_tutup" name="tanggal_tutup" type="date" required value="{{ old('tanggal_tutup', $lowongan->tanggal_tutup->format('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-600 bg-slate-50/50 text-slate-900">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end space-x-3">
                    <a href="{{ route('admin.lowongan.index') }}" class="px-5 py-2.5 rounded-xl font-bold text-slate-600 hover:bg-slate-100">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-white bg-brand-600 hover:bg-brand-700 shadow-md">Update Lowongan</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
