<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Usaha</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 40px 60px;
            font-size: 12pt;
        }
        .kop-surat {
            border-bottom: 4px double black;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .kop-surat table {
            width: 100%;
        }
        .kop-surat img {
            width: 90px;
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
        .content {
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
        .indent {
            text-indent: 50px;
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

    <div class="judul">SURAT KETERANGAN TIDAK MAMPU</div>
    <div class="nomor">Nomor: {{ $surat->nomor_surat }}</div>

    <div class="content">
        <p class="indent" style="text-align: justify">
            Yang bertanda tangan di bawah ini Kepala Desa Ciasmara Kecamatan Pamijahan Kabupaten Bogor, menerangkan bahwa:
        </p>

        <table>
            <tr><td>Nama</td><td>: {{ $surat->nama }}</td></tr>
            <tr><td>NIK</td><td>: {{ $surat->nik }}</td></tr>
            <tr><td>Tempat/Tgl Lahir</td><td>: {{ $surat->tempat_lahir }}, {{ \Carbon\Carbon::parse($surat->tanggal_lahir)->translatedFormat('d-m-Y') }}</td></tr>
            <tr><td>Pekerjaan</td><td>: {{ $surat->pekerjaan }}</td></tr>
            <tr><td>Alamat</td><td>: {{ $surat->alamat }}</td></tr>
        </table>
<p></p>
        <div class="content indent" style="text-align: justify">
            Nama tersebut di atas adalah benar Warga Desa kami dan berdasarkan Surat Pengantar dari Ketua RT dan RW bahwa yang bersangkutan adalah salah satu dari Keluarga Tidak Mampu.
        </div>
        <p></p>
        <div class="content" style="text-align: justify">
            Demikian surat keterangan ini dibuat berdasarkan pernyataan/keterangan yang bersangkutan dan untuk yang bersangkutan agar dapat dipergunakan sebagaimana mestinya.
        </div>

        <div style="width: 100%; text-align: right; margin-top: 40px;">
    <div style="display: inline-block; text-align: center; margin-right: 40px;">
        <p>Ciasmara, {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d F Y') }}</p>
        <p>Kepala Desa Ciasmara</p>
        <img src="{{ public_path('images/ttd.png') }}" alt="Tanda Tangan" style="width: 120px; height: auto; margin: 10px 0;">
        <p><strong><u>JUNAEDI, S.AP</u></strong></p>
    </div>
    </div>

</body>
</html>
