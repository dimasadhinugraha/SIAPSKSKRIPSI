<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Usaha</title>
    <style>
        .letter-content * { margin: 0; padding: 0; box-sizing: border-box; }
        .letter-content { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6; color: #000; background-color: #fff; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { width: 100px; height: 120px; margin: 0 auto 10px; }
        .header h2 { font-size: 14pt; font-weight: bold; margin: 5px 0; text-transform: uppercase; }
        .header h1 { font-size: 16pt; font-weight: bold; margin: 5px 0; text-transform: uppercase; }
        .header p { font-size: 10pt; margin: 2px 0; font-style: italic; }
        .divider { border-bottom: 3px solid #000; margin: 15px 0 20px 0; }
        .title { text-align: center; margin: 25px 0; }
        .title h3 { font-size: 14pt; font-weight: bold; text-decoration: underline; margin-bottom: 5px; }
        .title p { font-size: 11pt; }
        .content { text-align: justify; margin: 20px 0; }
        .content p { margin-bottom: 15px; }
        .data-table { margin: 20px 0 20px 40px; }
        .data-table table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 3px 0; vertical-align: top; }
        .data-table td:first-child { width: 180px; }
        .data-table td:nth-child(2) { width: 20px; text-align: center; }
        .footer { margin-top: 40px; }
        .signature-right { float: right; width: 250px; text-align: center; }
        .signature p { margin: 5px 0; }
        .signature .name { margin-top: 100px; font-weight: bold; text-decoration: underline; }
        .clear { clear: both; }
    </style>
</head>
<body>
    @php
        $biodata = $letterRequest->user->biodata;
        $birthDate = $biodata->birth_date ? \Carbon\Carbon::parse($biodata->birth_date)->format('d-m-Y') : '';
        $birthInfo = ($subjectDetails['birth_place'] ?? 'Bogor') . ', ' . $birthDate;
        $gender = $biodata->gender == 'L' ? 'Laki-laki' : 'Perempuan';
        $religion = $formData['agama'] ?? 'Islam';
        $job = $formData['pekerjaan'] ?? 'Wiraswasta';
        $fullAddress = $biodata->address;
        
        $lastApproval = $letterRequest->approvals()->where('status', 'approved')->orderBy('updated_at', 'desc')->first();
        $approvalDate = $lastApproval && $lastApproval->updated_at ? \Carbon\Carbon::parse($lastApproval->updated_at)->locale('id') : \Carbon\Carbon::now()->locale('id');
        $approvalDay = $approvalDate->format('d');
        $approvalMonth = $approvalDate->translatedFormat('F');
        $approvalYear = $approvalDate->format('Y');
        
        $monthRoman = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
        $currentMonth = (int) $letterRequest->created_at->format('m');
        $currentYear = $letterRequest->created_at->format('Y');
        $romanMonth = $monthRoman[$currentMonth];
        $letterNumber = '400.10.5.4/' . $letterRequest->request_number . '/' . $romanMonth . '/' . $currentYear;
        
        $jenisUsaha = $formData['jenis_usaha'] ?? '-';
        $tahunUsaha = $formData['tahun_usaha'] ?? '-';
        $wilayahUsaha = $formData['wilayah_usaha'] ?? 'Desa Ciasmara';
        $statusUsaha = $formData['status_usaha'] ?? 'Aktif';
    @endphp

    <div class="letter-content">

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
        <h3>SURAT KETERANGAN USAHA</h3>
        <p>Nomor: {{ $letterNumber }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan dibawah ini Kepala Desa Ciasmara Kecamatan Pamijahan Kabupaten Bogor, menerangkan bahwa :</p>
        
        <div class="data-table">
            <table>
                <tr><td>Nama</td><td>:</td><td><strong>{{ $subjectDetails['name'] ?? $letterRequest->user->name }}</strong></td></tr>
                <tr><td>NIK</td><td>:</td><td><strong>{{ $subjectDetails['nik'] ?? $letterRequest->user->nik }}</strong></td></tr>
                <tr><td>Tempat / Tgl. Lahir</td><td>:</td><td><strong>{{ $birthInfo }}</strong></td></tr>
                <tr><td>Jenis Kelamin</td><td>:</td><td><strong>{{ $gender }}</strong></td></tr>
                <tr><td>Agama</td><td>:</td><td><strong>{{ $religion }}</strong></td></tr>
                <tr><td>Pekerjaan</td><td>:</td><td><strong>{{ $job }}</strong></td></tr>
                <tr><td>Alamat</td><td>:</td><td><strong>{{ $fullAddress }}</strong></td></tr>
                <tr><td>Jenis Usaha</td><td>:</td><td><strong>{{ $jenisUsaha }}</strong></td></tr>
                <tr><td>Lama Usaha</td><td>:</td><td><strong>{{ $tahunUsaha }} Tahun</strong></td></tr>
                <tr><td>Lokasi Usaha</td><td>:</td><td><strong>{{ $wilayahUsaha }}</strong></td></tr>
                <tr><td>Status Usaha</td><td>:</td><td><strong>{{ $statusUsaha }}</strong></td></tr>
            </table>
        </div>

        <p>Orang tersebut diatas adalah benar warga Desa Ciasmara dan memiliki usaha <strong>{{ $jenisUsaha }}</strong> yang berlokasi di {{ $wilayahUsaha }}.</p>
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.</p>
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
