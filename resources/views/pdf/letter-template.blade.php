<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $letterType->name }}</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0;
        }
        .header p {
            margin: 2px 0;
            font-size: 10pt;
        }
        .letter-title {
            text-align: center;
            margin: 30px 0;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14pt;
            text-transform: uppercase;
        }
        .letter-number {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .content {
            text-align: justify;
            margin-bottom: 40px;
        }
        .content p {
            margin-bottom: 15px;
        }
        .data-table {
            margin: 20px 0;
        }
        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table td {
            padding: 5px 10px;
            vertical-align: top;
        }
        .data-table td:first-child {
            width: 200px;
        }
        .signature {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 250px;
        }
        .signature-space {
            height: 20px;
            margin: 10px 0;
        }
        .qr-code {
            margin: 10px 0;
        }
        .qr-code img {
            width: 120px;
            height: 120px;
        }
        .verification-info {
            font-size: 8pt;
            color: #666;
            margin-top: 5px;
            line-height: 1.2;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <!-- HEADER DESA -->
    <div class="header">
        <h1>Pemerintah Desa Ciasmara</h1>
        <h2>Kecamatan [Nama Kecamatan]</h2>
        <h2>Kabupaten [Nama Kabupaten]</h2>
        <p>Alamat: [Alamat Lengkap Kantor Desa]</p>
        <p>Telepon: [Nomor Telepon] | Email: admin@ciasmara.desa.id</p>
    </div>
    
    <!-- JUDUL SURAT -->
    <div class="letter-title">{{ $letterType->name }}</div>
    <div class="letter-number">Nomor: {{ $letterRequest->request_number }}/DESA/{{ $letterRequest->created_at->format('m/Y') }}</div>
    
    <!-- KONTEN SURAT -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Kepala Desa Ciasmara, Kecamatan [Nama Kecamatan], Kabupaten [Nama Kabupaten], dengan ini menerangkan bahwa:</p>

        <!-- DATA SUBJEK SURAT -->
        <div class="data-table">
            <table>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>: {{ $subjectDetails['name'] }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>: {{ $subjectDetails['nik'] }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>: {{ $subjectDetails['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>: {{ \Carbon\Carbon::parse($subjectDetails['birth_date'])->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $subjectDetails['address'] }}</td>
                </tr>
                <tr>
                    <td>RT/RW</td>
                    <td>: {{ $user->rt_rw }}</td>
                </tr>
                @if($subjectDetails['relationship'] !== 'Pemohon')
                <tr>
                    <td>Hubungan dengan Pemohon</td>
                    <td>: {{ $subjectDetails['relationship'] }}</td>
                </tr>
                @endif

                <!-- DATA FORM DINAMIS -->
                @if($formData)
                    @foreach($formData as $key => $value)
                        <tr>
                            <td>{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                            <td>: {{ $value }}</td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>

        @if($subjectDetails['relationship'] !== 'Pemohon')
        <!-- INFO PEMOHON -->
        <p style="margin-top: 20px; font-style: italic; font-size: 10pt;">
            <strong>Catatan:</strong> Surat ini diajukan oleh {{ $user->name }} (NIK: {{ $user->nik }})
            sebagai {{ strtolower($subjectDetails['relationship']) }} dari yang bersangkutan.
        </p>
        @endif

        <!-- KONTEN KHUSUS PER JENIS SURAT -->
        @if($letterType->name == 'Surat Keterangan Domisili')
            <p>Adalah benar warga Desa Ciasmara yang berdomisili di alamat tersebut di atas. Surat keterangan ini dibuat untuk keperluan: <strong>{{ $formData['keperluan'] ?? 'Administrasi' }}</strong>.</p>
        @elseif($letterType->name == 'Surat Pengantar SKCK')
            <p>Adalah benar warga Desa Ciasmara yang berkelakuan baik dan tidak pernah terlibat dalam tindakan kriminal. Surat pengantar ini dibuat untuk keperluan pembuatan SKCK di {{ $formData['kepolisian_tujuan'] ?? 'Kepolisian setempat' }} dengan keperluan: <strong>{{ $formData['keperluan'] ?? 'Administrasi' }}</strong>.</p>
        @elseif($letterType->name == 'Surat Keterangan Usaha')
            <p>Adalah benar memiliki usaha dengan nama <strong>{{ $formData['nama_usaha'] ?? 'Usaha' }}</strong>, bergerak di bidang <strong>{{ $formData['jenis_usaha'] ?? 'Perdagangan' }}</strong>, berlokasi di {{ $formData['alamat_usaha'] ?? 'Desa Ciasmara' }} dengan modal usaha sebesar Rp {{ number_format($formData['modal_usaha'] ?? 0, 0, ',', '.') }}.</p>
        @else
            <p>Adalah benar warga Desa Ciasmara yang memenuhi persyaratan untuk keperluan administrasi yang dimaksud.</p>
        @endif
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya dan dapat dipergunakan sebagaimana mestinya.</p>
    </div>
    
    <!-- TANDA TANGAN DIGITAL -->
    <div class="clearfix">
        <div class="signature">
            <p>Ciasmara, {{ now()->format('d F Y') }}</p>
            <p>Kepala Desa Ciasmara</p>

            <!-- QR CODE DIGITAL SIGNATURE -->
            <div class="qr-code">
                <div style="width: 120px; height: 120px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; background: #f9f9f9;">
                    <div style="text-align: center; font-size: 10px; color: #666;">
                        <div>QR CODE</div>
                        <div style="font-size: 8px;">{{ $letterRequest->request_number }}</div>
                        <div style="font-size: 7px;">Scan untuk verifikasi</div>
                    </div>
                </div>
            </div>

            <p><strong>[Nama Kepala Desa]</strong></p>
            <p>NIP. [NIP Kepala Desa]</p>

            <!-- VERIFICATION INFO -->
            <div class="verification-info">
                <p><strong>Tanda Tangan Digital</strong></p>
                <p>Scan QR Code untuk verifikasi</p>
                <p>Surat No: {{ $letterRequest->request_number }}</p>
                <p>Subjek: {{ $subjectDetails['name'] }}</p>
                <p>Tanggal: {{ $letterRequest->final_processed_at ? $letterRequest->final_processed_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
