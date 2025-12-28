<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kematian</title>
    <style>
        .letter-content * { margin: 0; padding: 0; box-sizing: border-box; }
        .letter-content { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.5; color: #000; background-color: #fff; }
        .header { text-align: center; margin-bottom: 25px; }
        .logo { width: 100px; height: 120px; margin: 0 auto 10px; }
        .header h2 { font-size: 14pt; font-weight: bold; margin: 5px 0; text-transform: uppercase; }
        .header h1 { font-size: 16pt; font-weight: bold; margin: 5px 0; text-transform: uppercase; }
        .header p { font-size: 10pt; margin: 2px 0; font-style: italic; }
        .divider { border-bottom: 3px solid #000; margin: 15px 0 20px 0; }
        .title { text-align: center; margin: 20px 0; }
        .title h3 { font-size: 14pt; font-weight: bold; text-decoration: underline; margin-bottom: 5px; }
        .title p { font-size: 11pt; }
        .content { text-align: justify; margin: 15px 0; }
        .content p { margin-bottom: 12px; }
        .data-table { margin: 15px 0 15px 40px; }
        .data-table table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 2px 0; vertical-align: top; }
        .data-table td:first-child { width: 180px; }
        .data-table td:nth-child(2) { width: 20px; text-align: center; }
        .footer { margin-top: 30px; }
        .signature-right { float: right; width: 250px; text-align: center; }
        .signature p { margin: 5px 0; }
        .signature .name { margin-top: 100px; font-weight: bold; text-decoration: underline; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="letter-content">
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
        $letterNumber = '400.12.3.1/' . $letterRequest->request_number . '/' . $romanMonth . '/' . $currentYear;
        
        // Data Almarhum
        $namaAlmarhum = $formData['nama_almarhum'] ?? '-';
        $tempatLahirAlmarhum = $formData['tempat_lahir_almarhum'] ?? 'Bogor';
        $tanggalLahirAlmarhum = isset($formData['tanggal_lahir_almarhum']) ? \Carbon\Carbon::parse($formData['tanggal_lahir_almarhum'])->locale('id')->translatedFormat('d F Y') : '-';
        $umurAlmarhum = $formData['umur_almarhum'] ?? '-';
        $agamaAlmarhum = $formData['agama_almarhum'] ?? 'Islam';
        $pekerjaanAlmarhum = $formData['pekerjaan_almarhum'] ?? '-';
        $alamatAlmarhum = $formData['alamat_almarhum'] ?? '-';
        $tempatMeninggal = $formData['tempat_meninggal'] ?? '-';
        $tanggalMeninggal = isset($formData['tanggal_meninggal']) ? \Carbon\Carbon::parse($formData['tanggal_meninggal'])->locale('id')->translatedFormat('d F Y') : '-';
        $waktuMeninggal = $formData['waktu_meninggal'] ?? '-';
        $sebabMeninggal = $formData['sebab_meninggal'] ?? '-';
        
        // Data Pelapor
        $namaPelapor = $formData['nama_pelapor'] ?? $letterRequest->user->name;
        $hubunganPelapor = $formData['hubungan_pelapor'] ?? 'Keluarga';
    @endphp

    <div class="header">
        <table width="100%" style="margin-bottom: 10px;">
            <tr>
                <td width="60" style="vertical-align: top;">
                    <img src="{{ $logoSrc ?? '/images/ciasmara.png' }}" width="100px" height="120px" alt="Logo" class="logo">
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
        <h3>SURAT KETERANGAN KEMATIAN</h3>
        <p>Nomor: {{ $letterNumber }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan dibawah ini Kepala Desa Ciasmara Kecamatan Pamijahan Kabupaten Bogor, menerangkan bahwa :</p>
        
        <div class="data-table">
            <table>
                <tr><td colspan="3"><strong>Data Almarhum/Almarhumah:</strong></td></tr>
                <tr><td>Nama</td><td>:</td><td><strong>{{ $namaAlmarhum }}</strong></td></tr>
                <tr><td>Tempat / Tgl. Lahir</td><td>:</td><td><strong>{{ $tempatLahirAlmarhum }}, {{ $tanggalLahirAlmarhum }}</strong></td></tr>
                <tr><td>Umur</td><td>:</td><td><strong>{{ $umurAlmarhum }} Tahun</strong></td></tr>
                <tr><td>Agama</td><td>:</td><td><strong>{{ $agamaAlmarhum }}</strong></td></tr>
                <tr><td>Pekerjaan</td><td>:</td><td><strong>{{ $pekerjaanAlmarhum }}</strong></td></tr>
                <tr><td>Alamat</td><td>:</td><td><strong>{{ $alamatAlmarhum }}</strong></td></tr>
                <tr><td colspan="3" style="padding-top: 10px;"><strong>Data Kematian:</strong></td></tr>
                <tr><td>Meninggal Pada</td><td>:</td><td><strong>{{ $tanggalMeninggal }}, Pukul {{ $waktuMeninggal }}</strong></td></tr>
                <tr><td>Tempat Meninggal</td><td>:</td><td><strong>{{ $tempatMeninggal }}</strong></td></tr>
                <tr><td>Sebab Kematian</td><td>:</td><td><strong>{{ $sebabMeninggal }}</strong></td></tr>
                <tr><td colspan="3" style="padding-top: 10px;"><strong>Data Pelapor:</strong></td></tr>
                <tr><td>Nama Pelapor</td><td>:</td><td><strong>{{ $namaPelapor }}</strong></td></tr>
                <tr><td>Hubungan</td><td>:</td><td><strong>{{ $hubunganPelapor }}</strong></td></tr>
            </table>
        </div>

        <p>Demikian surat keterangan ini dibuat dengan sebenarnya berdasarkan laporan yang dapat dipertanggungjawabkan untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="footer">
        <div class="signature-right">
            <p>Ciasmara, {{ $approvalDay }} {{ $approvalMonth }} {{ $approvalYear }}</p>
            <p>Kepala Desa,</p>
             <p class="name" style="padding-top: 100px;"><u>JUNAEDI,S.AP</u></p>
        </div>
        <div class="clear"></div>
    </div>
    </div>
</body>
</html>
