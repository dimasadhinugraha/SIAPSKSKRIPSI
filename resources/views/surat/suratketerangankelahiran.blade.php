<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kelahiran</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 10pt; line-height: 1.4; color: #000; background-color: #fff; padding: 1.5cm 2cm; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { width: 100px; height: 120px; margin: 0 auto 10px; }
        .header h2 { font-size: 13pt; font-weight: bold; margin: 3px 0; text-transform: uppercase; }
        .header h1 { font-size: 15pt; font-weight: bold; margin: 3px 0; text-transform: uppercase; }
        .header p { font-size: 9pt; margin: 2px 0; font-style: italic; }
        .divider { border-bottom: 3px solid #000; margin: 12px 0 15px 0; }
        .title { text-align: center; margin: 15px 0; }
        .title h3 { font-size: 13pt; font-weight: bold; text-decoration: underline; margin-bottom: 4px; }
        .title p { font-size: 10pt; }
        .content { text-align: justify; margin: 12px 0; }
        .content p { margin-bottom: 10px; }
        .data-table { margin: 12px 0 12px 30px; }
        .data-table table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 1px 0; vertical-align: top; font-size: 10pt; }
        .data-table td:first-child { width: 160px; }
        .data-table td:nth-child(2) { width: 15px; text-align: center; }
        .footer { margin-top: 25px; }
        .signature-right { float: right; width: 220px; text-align: center; }
        .signature p { margin: 4px 0; }
        .signature .name { margin-top: 100px; font-weight: bold; text-decoration: underline; }
        .clear { clear: both; }
    </style>
</head>
<body>
    @php
        $lastApproval = $letterRequest->approvals()->where('status', 'approved')->orderBy('updated_at', 'desc')->first();
        $approvalDate = $lastApproval && $lastApproval->updated_at ? \Carbon\Carbon::parse($lastApproval->updated_at)->locale('id') : \Carbon\Carbon::now()->locale('id');
        $approvalDay = $approvalDate->format('d');
        $approvalMonth = $approvalDate->translatedFormat('F');
        $approvalYear = $approvalDate->format('Y');
        
        $monthRoman = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
        $currentMonth = (int) $letterRequest->created_at->format('m');
        $currentYear = $letterRequest->created_at->format('Y');
        $romanMonth = $monthRoman[$currentMonth];
        $letterNumber = '400.12.3/' . $letterRequest->request_number . '/' . $romanMonth . '/' . $currentYear;
        
        // Data Anak
        $namaAnak = $formData['nama_anakbaru'] ?? '-';
        $jenisKelamin = $formData['jeniskelamin'] ?? 'Laki-laki';
        $anakKe = $formData['angka'] ?? '-';
        $anakKeHuruf = $formData['huruf'] ?? '-';
        $tempatLahir = $formData['tempat_lahir'] ?? 'Bogor';
        $hariLahir = $formData['hari_lahir'] ?? '-';
        $tanggalLahir = isset($formData['tanggal_lahir']) ? \Carbon\Carbon::parse($formData['tanggal_lahir'])->locale('id')->translatedFormat('d F Y') : '-';
        $waktuLahir = $formData['waktu_lahir'] ?? '-';
        
        // Data Ayah
        $namaAyah = $formData['nama_ayah'] ?? '-';
        $tempatLahirAyah = $formData['tempat_lahir_ayah'] ?? '-';
        $tanggalLahirAyah = isset($formData['tanggal_lahir_ayah']) ? \Carbon\Carbon::parse($formData['tanggal_lahir_ayah'])->locale('id')->translatedFormat('d F Y') : '-';
        $pekerjaanAyah = $formData['pekerjaan_ayah'] ?? '-';
        $agamaAyah = $formData['agama_ayah'] ?? 'Islam';
        $nikAyah = $formData['nik_ayah'] ?? '-';
        $alamatAyah = $formData['alamat_ayah'] ?? '-';
        
        // Data Ibu
        $namaIbu = $formData['nama_ibu'] ?? '-';
        $tempatLahirIbu = $formData['tempat_lahir_ibu'] ?? '-';
        $tanggalLahirIbu = isset($formData['tanggal_lahir_ibu']) ? \Carbon\Carbon::parse($formData['tanggal_lahir_ibu'])->locale('id')->translatedFormat('d F Y') : '-';
        $pekerjaanIbu = $formData['pekerjaan_ibu'] ?? '-';
        $agamaIbu = $formData['agama_ibu'] ?? 'Islam';
        $nikIbu = $formData['nik_ibu'] ?? '-';
        $alamatIbu = $formData['alamat_ibu'] ?? '-';
    @endphp

    <div class="header">
        <table width="100%" style="margin-bottom: 8px;">
            <tr>
                <td width="50" style="vertical-align: top;">
                    @if(file_exists(public_path('images/ciasmara.png')))
                        <img src="{{ public_path('images/ciasmara.png') }}" width="90px" height="110px" alt="Logo" class="logo">
                    @else
                        <div style="width: 50px; height: 50px; border: 2px solid #000; display: flex; align-items: center; justify-content: center; font-size: 7pt;">LOGO</div>
                    @endif
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <h2>PEMERINTAH KABUPATEN BOGOR</h2>
                    <h2>KECAMATAN PAMIJAHAN</h2>
                    <h1>DESA CIASMARA</h1>
                    <p><i>Alamat : Jl. KH Abdul Hamid Km. 15 Kp. Parakan Pasar Rt 02/07 Desa Ciasmara</i></p>
                    <p><i>PAMIJAHAN 16810</i></p>
                </td>
            </tr>
        </table>
        <div class="divider"></div>
    </div>

    <div class="title">
        <h3>SURAT KETERANGAN KELAHIRAN</h3>
        <p>Nomor: {{ $letterNumber }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan dibawah ini Kepala Desa Ciasmara Kecamatan Pamijahan Kabupaten Bogor, menerangkan bahwa:</p>
        
        <div class="data-table">
            <table>
                <tr><td colspan="3"><strong>Data Bayi:</strong></td></tr>
                <tr><td>Nama</td><td>:</td><td><strong>{{ $namaAnak }}</strong></td></tr>
                <tr><td>Jenis Kelamin</td><td>:</td><td><strong>{{ $jenisKelamin }}</strong></td></tr>
                <tr><td>Anak Ke</td><td>:</td><td><strong>{{ $anakKe }} ({{ $anakKeHuruf }})</strong></td></tr>
                <tr><td>Lahir Pada</td><td>:</td><td><strong>{{ $hariLahir }}, {{ $tanggalLahir }}</strong></td></tr>
                <tr><td>Pukul</td><td>:</td><td><strong>{{ $waktuLahir }}</strong></td></tr>
                <tr><td>Tempat Lahir</td><td>:</td><td><strong>{{ $tempatLahir }}</strong></td></tr>
                
                <tr><td colspan="3" style="padding-top: 8px;"><strong>Data Ayah:</strong></td></tr>
                <tr><td>Nama</td><td>:</td><td><strong>{{ $namaAyah }}</strong></td></tr>
                <tr><td>NIK</td><td>:</td><td><strong>{{ $nikAyah }}</strong></td></tr>
                <tr><td>Tempat / Tgl. Lahir</td><td>:</td><td><strong>{{ $tempatLahirAyah }}, {{ $tanggalLahirAyah }}</strong></td></tr>
                <tr><td>Pekerjaan</td><td>:</td><td><strong>{{ $pekerjaanAyah }}</strong></td></tr>
                <tr><td>Agama</td><td>:</td><td><strong>{{ $agamaAyah }}</strong></td></tr>
                <tr><td>Alamat</td><td>:</td><td><strong>{{ $alamatAyah }}</strong></td></tr>
                
                <tr><td colspan="3" style="padding-top: 8px;"><strong>Data Ibu:</strong></td></tr>
                <tr><td>Nama</td><td>:</td><td><strong>{{ $namaIbu }}</strong></td></tr>
                <tr><td>NIK</td><td>:</td><td><strong>{{ $nikIbu }}</strong></td></tr>
                <tr><td>Tempat / Tgl. Lahir</td><td>:</td><td><strong>{{ $tempatLahirIbu }}, {{ $tanggalLahirIbu }}</strong></td></tr>
                <tr><td>Pekerjaan</td><td>:</td><td><strong>{{ $pekerjaanIbu }}</strong></td></tr>
                <tr><td>Agama</td><td>:</td><td><strong>{{ $agamaIbu }}</strong></td></tr>
                <tr><td>Alamat</td><td>:</td><td><strong>{{ $alamatIbu }}</strong></td></tr>
            </table>
        </div>

        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="footer">
        <div class="signature-right">
            <p>Ciasmara, {{ $approvalDay }} {{ $approvalMonth }} {{ $approvalYear }}</p>
            <p>Kepala Desa,</p>
             <p class="name" style="padding-top: 100px;"><u>JUNAEDI,S.AP</u></p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
