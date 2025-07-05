<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Domisili</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 40px 60px;
            font-size: 12pt;
        }
        .kop-surat {
            border-bottom: 4px double black;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        .kop-surat table {
            width: 100%;
        }
        .kop-surat img {
            width: 80px;
        }
        .kop-surat td {
            vertical-align: top;
            text-align: center;
        }
        .kop-text h3, .kop-text h4, .kop-text p {
            margin: 0;
            line-height: 1.4;
        }
        .kop-text h3 {
            font-size: 16pt;
        }
        .kop-text h4 {
            font-size: 14pt;
        }
        .kop-text p {
            font-size: 12pt;
        }
        .judul {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            margin-top: 15px;
            font-size: 14pt;
        }
        .nomor {
            text-align: center;
            margin-bottom: 20px;
        }
        .indent {
            text-indent: 50px;
            margin-bottom: 10px;
        }
        table.data {
            margin-left: 40px;
            line-height: 1.6;
        }
        .ttd {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <table>
            <tr>
                <td style="width: 15%; text-align: center;">
                    <img src="{{ public_path('images/ciasmara.png') }}" alt="Logo">
                </td>
                <td class="kop-text">
                    <h3>PEMERINTAH KABUPATEN BOGOR</h3>
                    <h4>KECAMATAN PAMIJAHAN</h4>
                    <h3>DESA CIASMARA</h3>
                    <p>Alamat: Jl. KH Abdul Hamid Km. 15 Kp. Parabakti Pasar Rt 02/07 Desa Ciasmara</p>
                    <h4>PAMIJAHAN 16810</h4>
                </td>
            </tr>
        </table>
    </div>

    <div class="judul">SURAT KETERANGAN DOMISILI</div>
    <div class="nomor">Nomor: {{ $surat->nomor_surat }}</div>

    <div class="content">
        Yang bertanda tangan dibawah ini, Kepala Desa Ciasmara Kecamatan Pamijahan Kabupaten Bogor dengan ini menerangkan bahwa:
    </div>
    <p></p>
    <table class="data">
        <tr><td>Nama</td><td>: {{ $surat->nama }}</td></tr>
        <tr><td>NIK</td><td>: {{ $surat->nik }}</td></tr>
        <tr><td>Tempat/Tgl. Lahir</td><td>: {{ $surat->tempat_lahir }}, {{ \Carbon\Carbon::parse($surat->tanggal_lahir)->translatedFormat('d-m-Y') }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>: {{ $surat->jeniskelamin }}</td></tr>
        <tr><td>Agama</td><td>: {{ $surat->agama }}</td></tr>
        <tr><td>Pekerjaan</td><td>: {{ $surat->pekerjaan }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $surat->alamat }}</td></tr>
    </table>
    <p></p>
    <div style="indent">
        Nama tersebut di atas adalah benar pada saat ini berdomisili di Kp {{ $surat->kampung }} Desa Ciasmara Kecamatan Pamijahan Kabupaten Bogor.
    </div>
<p></p>
    <div style="content">
        Demikian surat keterangan ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.
    </div>

    <div style="width: 100%; text-align: right; margin-top: 40px;">
    <div style="display: inline-block; text-align: center; margin-right: 40px;">
        <p>Ciasmara, {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d F Y') }}</p>
        <p>Kepala Desa Ciasmara</p>

        @if(isset($qrCodeBase64))
            <!-- QR Code Digital Signature -->
            <img src="{{ $qrCodeBase64 }}" alt="QR Code Verifikasi" style="width: 100px; height: 100px; margin: 10px 0;">
            <p style="font-size: 8pt; color: #666;">Tanda Tangan Digital</p>
            <p style="font-size: 8pt; color: #666;">Scan untuk verifikasi</p>
        @else
            <!-- Traditional Signature -->
            <img src="{{ public_path('images/ttd.png') }}" alt="Tanda Tangan" style="width: 120px; height: auto; margin: 10px 0;">
        @endif

        <p><strong><u>JUNAEDI, S.AP</u></strong></p>
    </div>
    </div>

</body>
</html>
