<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Rekrutmen Karyawan</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.2cm 1.5cm 1.2cm 1.5cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.4;
        }
        /* Kop Surat Header */
        .kop-header {
            width: 100%;
            border-bottom: 3px double #0f172a;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #0284c7;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .company-sub {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        .doc-title {
            text-align: center;
            margin-bottom: 15px;
        }
        .doc-title h2 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #0f172a;
            letter-spacing: 0.5px;
        }
        .doc-title p {
            font-size: 10px;
            color: #64748b;
            margin: 3px 0 0 0;
        }
        /* Table Styling */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 6px;
            border: 1px solid #0f172a;
            text-align: left;
        }
        table.data-table td {
            padding: 7px 6px;
            border: 1px solid #cbd5e1;
            font-size: 10px;
            vertical-align: top;
        }
        table.data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 3px;
        }
        .badge-success { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-danger { background-color: #ffe4e6; color: #be123c; border: 1px solid #fecdd3; }
        .badge-warning { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        
        /* Signature Block */
        .signature-section {
            width: 100%;
            margin-top: 30px;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-space {
            height: 65px;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <!-- Kop Surat Header -->
    <table class="kop-header">
        <tr>
            <td style="width: 70%;">
                <div class="company-name">PT SARILING ANEKA ENERGI</div>
                <div class="company-sub">Distributor & Manufacturer Genset Diesel Heavy Duty | Sales & Service Specialist</div>
                <div class="company-sub">Jl. Raya Serang Km 14.5 Cikupa, Tangerang - Banten | Telp: (021) 5960000 | www.sariling.co.id</div>
            </td>
            <td style="width: 30%; text-align: right; vertical-align: top;">
                <div style="font-size: 9px; color: #64748b;">
                    <strong>Tanggal Cetak:</strong> {{ $tanggalCetak }}<br>
                    <strong>Sistem:</strong> E-Recruitment v1.0
                </div>
            </td>
        </tr>
    </table>

    <!-- Document Title -->
    <div class="doc-title">
        <h2>Laporan Rekapitulasi Penerimaan Karyawan</h2>
        <p>
            Posisi: <strong>{{ $selectedLowongan ? $selectedLowongan->judul_posisi : 'Seluruh Posisi Lowongan Pekerjaan' }}</strong>
        </p>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 12%;">Kode Registrasi</th>
                <th style="width: 16%;">Nama Pelamar</th>
                <th style="width: 16%;">Kontak & Email</th>
                <th style="width: 18%;">Posisi Lowongan</th>
                <th style="width: 7%; text-align: center;">Nilai Tes</th>
                <th style="width: 7%; text-align: center;">Nilai Wawancara</th>
                <th style="width: 10%; text-align: center;">Keputusan</th>
                <th style="width: 10%;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lamarans as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-weight: bold; color: #0284c7;">{{ $item->kode_pendaftaran }}</td>
                    <td style="font-weight: bold; color: #0f172a;">{{ $item->user->name }}</td>
                    <td>
                        {{ $item->user->email }}<br>
                        <span style="color: #64748b; font-size: 9px;">HP: {{ $item->user->no_hp ?? '-' }}</span>
                    </td>
                    <td>{{ $item->lowongan->judul_posisi }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $item->hasilSeleksi->nilai_tes ?? '-' }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $item->hasilSeleksi->nilai_wawancara ?? '-' }}</td>
                    <td style="text-align: center;">
                        @if($item->status_lamaran === 'diterima')
                            <span class="badge badge-success">DITERIMA</span>
                        @elseif($item->status_lamaran === 'ditolak')
                            <span class="badge badge-danger">DITOLAK</span>
                        @else
                            <span class="badge badge-warning">{{ str_replace('_', ' ', strtoupper($item->status_lamaran)) }}</span>
                        @endif
                    </td>
                    <td style="font-size: 9px; color: #475569;">
                        {{ $item->catatan_admin ?? ($item->hasilSeleksi->catatan_evaluasi ?? '-') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 20px; color: #94a3b8;">
                        Tidak ada data pelamar yang sesuai dengan kriteria laporan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <p style="margin: 0; font-size: 10px; color: #475569;">Tangerang, {{ now()->format('d F Y') }}</p>
            <p style="margin: 3px 0 0 0; font-weight: bold; color: #0f172a;">Manager Human Resource Dept.</p>
            <div class="signature-space"></div>
            <p style="margin: 0; font-weight: bold; text-decoration: underline; color: #0f172a;">Manager HRD Sariling</p>
            <p style="margin: 2px 0 0 0; font-size: 9px; color: #64748b;">PT Sariling Aneka Energi</p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>
