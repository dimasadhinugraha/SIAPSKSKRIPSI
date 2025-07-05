<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kelahiran</title>
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

<div class="judul">SURAT KETERANGAN KELAHIRAN</div>
<div class="nomor">Nomor : {{ $surat->nomor_surat }}</div>

<div class="isi">
<div class="content indent" style="text-align: justify">
    Yang bertanda tangan dibawah ini Kepala Desa Ciasmara Kecamatan Pamijahan Kabupaten Bogor, menerangkan bahwa berdasarkan Buku Induk Penduduk yang ada pada Kantor kami terdaftar seorang {{ $surat->jeniskelamin }} bernama :<br><br>
    </div>

    <center><strong>“ {{ $surat->nama_anakbaru }} @if($surat->jeniskelamin === 'Perempuan')* @endif ”</strong></center><br>

    Adalah anak ke : {{ $surat->angka }} ( {{ $surat->huruf }} ) dari :<br><br>
    <p></p>
    <strong>Ayah</strong><br>
    <table style="width: 100%; line-height: 1.6;">
        <tr>
            <td style="width: 30%;">Nama</td>
            <td style="width: 2%;">:</td>
            <td>{{ $surat->nama_ayah }}</td>
        </tr>
        <tr>
            <td>Tempat Tgl Lahir</td>
            <td>:</td>
            <td>{{ $surat->tempat_lahir_ayah }}, {{ \Carbon\Carbon::parse($surat->tanggal_lahir_ayah)->translatedFormat('d-m-Y') }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $surat->pekerjaan_ayah }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $surat->agama_ayah }}</td>
        </tr>
        <tr>
            <td>No. KTP</td>
            <td>:</td>
            <td>{{ $surat->nik_ayah }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $surat->alamat_ayah }}</td>
        </tr>
    </table><br>
    <p></p>
    <strong>Ibu</strong><br>
    <table style="width: 100%; line-height: 1.6;">
        <tr>
            <td style="width: 30%;">Nama</td>
            <td style="width: 2%;">:</td>
            <td>{{ $surat->nama_ibu }}</td>
        </tr>
        <tr>
            <td>Tempat Tgl Lahir</td>
            <td>:</td>
            <td>{{ $surat->tempat_lahir_ibu }}, {{ \Carbon\Carbon::parse($surat->tanggal_lahir_ibu)->translatedFormat('d-m-Y') }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $surat->pekerjaan_ibu }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $surat->agama_ibu }}</td>
        </tr>
        <tr>
            <td>No. KTP</td>
            <td>:</td>
            <td>{{ $surat->nik_ibu }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $surat->alamat_ibu }}</td>
        </tr>
    </table><br>
</div>

<div style="page-break-before: always;" style="text-align: justify">
    Nama tersebut di atas benar dilahirkan di {{ $surat->tempat_lahir }} pada hari {{ $surat->hari_lahir }} tanggal {{ \Carbon\Carbon::parse($surat->tanggal_lahir)->translatedFormat('d-m-Y') }}, pukul {{ $surat->waktu_lahir }} WIB.<br><br>

    Demikian surat keterangan ini kami buat dengan penuh tanggung jawab atas kebenarannya.
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
