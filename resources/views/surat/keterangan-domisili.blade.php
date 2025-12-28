<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Domisili</title>
    <style>
        .letter-content * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        .letter-content {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            background-color: #fff;
        }
        
        .letter-content .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .letter-content .logo {
            width: 100px;
            height: 120px;
            margin: 0 auto 10px;
        }
        
        .letter-content .header h2 {
            font-size: 14pt;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .letter-content .header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .letter-content .header p {
            font-size: 10pt;
            margin: 2px 0;
            font-style: italic;
        }
        
        .letter-content .divider {
            border-bottom: 3px solid #000;
            margin: 15px 0 20px 0;
        }
        
        .letter-content .title {
            text-align: center;
            margin: 25px 0;
        }
        
        .letter-content .title h3 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
        }
        
        .letter-content .title p {
            font-size: 11pt;
        }
        
        .letter-content .content {
            text-align: justify;
            margin: 20px 0;
        }
        
        .letter-content .content p {
            margin-bottom: 15px;
        }
        
        .letter-content .data-table {
            margin: 20px 0 20px 40px;
        }
        
        .letter-content .data-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .letter-content .data-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        
        .letter-content .data-table td:first-child {
            width: 150px;
        }
        
        .letter-content .data-table td:nth-child(2) {
            width: 20px;
            text-align: center;
        }
        
        .letter-content .footer {
            margin-top: 40px;
        }
        
        .letter-content .footer-text {
            text-align: justify;
            margin-bottom: 30px;
        }
        
        .letter-content .signature {
            margin-top: 20px;
            text-align: center;
        }
        
        .letter-content .signature-right {
            float: right;
            width: 250px;
            text-align: center;
        }
        
        .letter-content .signature p {
            margin: 5px 0;
        }
        
        .letter-content .signature .name {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
        
        .letter-content .clear {
            clear: both;
        }
        
        .letter-content .stamp-box {
            width: 80px;
            height: 80px;
            border: 2px solid #000;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    @php
        // Get user biodata
        $biodata = $letterRequest->user->biodata;
        
        // Parse RT/RW from biodata
        $rtRw = $biodata->rt_rw ?? '';
        $rtNumber = '';
        $rwNumber = '';
        
        if (preg_match('/(\d+)\/(\d+)/', $rtRw, $matches)) {
            $rtNumber = str_pad($matches[1], 3, '0', STR_PAD_LEFT);
            $rwNumber = str_pad($matches[2], 3, '0', STR_PAD_LEFT);
        } elseif (preg_match('/RT\s*(\d+)\s*\/\s*RW\s*(\d+)/i', $rtRw, $matches)) {
            $rtNumber = str_pad($matches[1], 3, '0', STR_PAD_LEFT);
            $rwNumber = str_pad($matches[2], 3, '0', STR_PAD_LEFT);
        }
        
        // Format tanggal lahir
        $birthDate = '';
        if ($biodata->birth_date) {
            $date = \Carbon\Carbon::parse($biodata->birth_date);
            $birthDate = $date->format('d-m-Y');
        }
        
        // Format tempat, tanggal lahir
        $birthInfo = ($subjectDetails['birth_place'] ?? 'Bogor') . ', ' . $birthDate;
        
        // Gender
        $gender = $biodata->gender == 'L' ? 'Laki-laki' : 'Perempuan';
        
        // Agama - ambil dari biodata, fallback ke form_data, default Islam
        $religion = $biodata->agama ?? $formData['agama'] ?? 'Islam';
        
        // Pekerjaan
        $job = $formData['pekerjaan'] ?? 'Wiraswasta';
        
        // Alamat lengkap
        $fullAddress = $biodata->address;
        
        // Extract kampung from address or form_data
        $kampung = $formData['kampung'] ?? '';
        if (empty($kampung)) {
            // Try to extract from address if starts with "Kp."
            if (preg_match('/Kp\.?\s*([^,\n]+)/i', $fullAddress, $kampungMatch)) {
                $kampung = trim($kampungMatch[1]);
            } else {
                // Get first part before comma as kampung
                $addressParts = explode(',', $fullAddress);
                $kampung = trim($addressParts[0]);
            }
        }
        
        // Tanggal surat - dari approval terakhir (RW)
        $lastApproval = $letterRequest->approvals()
            ->where('status', 'approved')
            ->orderBy('updated_at', 'desc')
            ->first();
        
        if ($lastApproval && $lastApproval->updated_at) {
            $approvalDate = \Carbon\Carbon::parse($lastApproval->updated_at)->locale('id');
            $approvalDay = $approvalDate->format('d');
            $approvalMonth = $approvalDate->translatedFormat('F');
            $approvalYear = $approvalDate->format('Y');
        } else {
            $approvalDate = \Carbon\Carbon::now()->locale('id');
            $approvalDay = $approvalDate->format('d');
            $approvalMonth = $approvalDate->translatedFormat('F');
            $approvalYear = $approvalDate->format('Y');
        }
        
        // Bulan dalam angka romawi
        $monthRoman = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $currentMonth = (int) $letterRequest->created_at->format('m');
        $currentYear = $letterRequest->created_at->format('Y');
        $romanMonth = $monthRoman[$currentMonth];
        
        // Nomor surat: 400.12.2.1/nomor_urut/bulan_romawi/tahun
        $letterNumber = '400.12.2.1/' . $letterRequest->request_number . '/' . $romanMonth . '/' . $currentYear;
    @endphp

    <div class="letter-content">
    <div class="header">
        <table width="100%" style="margin-bottom: 10px;">
            <tr>
                <td width="60" style="vertical-align: top;">
                    <img src="{{ $logoSrc ?? '/images/ciasmara.png' }}" width="100px" height="360px" alt="Logo" class="logo">
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
        <h3>SURAT KETERANGAN DOMISILI</h3>
        <p>Nomor: {{ $letterNumber }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan dibawah ini Kepala Desa Ciasmara Kecamatan Pamijahan Kabupaten Bogor, menerangkan bahwa :</p>
        
        <div class="data-table">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong>{{ $subjectDetails['name'] ?? $letterRequest->user->name }}</strong></td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td><strong>{{ $subjectDetails['nik'] ?? $letterRequest->user->nik }}</strong></td>
                </tr>
                <tr>
                    <td>Tempat / Tgl. Lahir</td>
                    <td>:</td>
                    <td><strong>{{ $birthInfo }}</strong></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td><strong>{{ $gender }}</strong></td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>:</td>
                    <td><strong>{{ $religion }}</strong></td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>:</td>
                    <td><strong>{{ $job }}</strong></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><strong>{{ $fullAddress }}</strong></td>
                </tr>
            </table>
        </div>

        <p>Nama tersebut diatas adalah benar, pada saat ini berdomisili di Kp. {{ $kampung }} Desa Ciasmara Kecamatan Pamijahan Kabupaten Bogor.</p>
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="footer">
        <div class="signature-right">
            <p>Ciasmara, {{ $approvalDay }} {{ $approvalMonth }} {{ $approvalYear }}</p>
            <p class="name" style="padding-top: 100px;"><u>JUNAEDI,S.AP</u></p>
        </div>
        <div class="clear"></div>
    </div>
    </div>

</body>
</html>
