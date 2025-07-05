<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kelahiran</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 40px;
        }
        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat img {
            width: 80px;
            height: 80px;
            margin-right: 15px;
        }
        .kop-surat .text {
            flex: 1;
        }
        .kop-surat .text h3, .kop-surat .text h4, .kop-surat .text p {
            margin: 0;
            padding: 0;
        }
        .judul {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 18px;
            margin-top: 10px;
        }
        .nomor {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin: 20px 0;
        }
        .indent {
            text-indent: 50px;
        }
        table {
            margin-left: 30px;
            margin-bottom: 10px;
        }
        .ttd {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <img src="{{ public_path('images/ciasmara.png') }}" alt="Logo">
        <div class="text">
            <h3>PEMERINTAH KABUPATEN BOGOR</h3>
            <h4>KECAMATAN PAMIJAHAN</h4>
            <h4>DESA CIASMARA</h4>
            <p>Alamat: Jl. KH Abdul Hamid Km. 15 Kp. Parabakti Pasar Rt 02/07 Desa Ciasmara</p>
            <p><strong>PAMIJAHAN 16810</strong></p>
        </div>
    </div>

    <div class="judul">SURAT KETERANGAN KELAHIRAN</div>
    <div class="nomor">Nomor: {{ $surat->nomor_surat }}</div>

    <div class="content">
        <p class="indent">
            Yang bertanda tangan dibawah ini Kepala Desa Ciasmara Kecamatan Pamijahan Kabupaten Bogor, menerangkan bahwa berdasarkan Buku Induk Penduduk yang ada pada Kantor kami terdaftar seorang {{ $surat->jenis_kelamin }} bernama:
        </p>

        <h3 style="text-align: center;">“ {{ $surat->nama_anakbaru }} ”</h3>

        <p class="indent">
            Adalah anak ke: {{ $surat->angka }} ({{ $surat->huruf }}) dari:
        </p>

        <table>
            <tr><td><strong>Ayah</strong></td></tr>
            <tr><td>Nama</td><td>: {{ $surat->nama_ayah }}</td></tr>
            <tr><td>Tempat/Tgl Lahir</td><td>: {{ $surat->tempat_lahir_ayah }}, {{ \Carbon\Carbon::parse($surat->tanggal_lahir_ayah)->translatedFormat('d-m-Y') }}</td></tr>
            <tr><td>Pekerjaan</td><td>: {{ $surat->pekerjaan_ayah }}</td></tr>
            <tr><td>Agama</td><td>: {{ $surat->agama_ayah }}</td></tr>
            <tr><td>No. KTP</td><td>: {{ $surat->nik_ayah }}</td></tr>
            <tr><td>Alamat</td><td>: {{ $surat->alamat_ayah }}</td></tr>
        </table>

        <table>
            <tr><td><strong>Ibu</strong></td></tr>
            <tr><td>Nama</td><td>: {{ $surat->nama_ibu }}</td></tr>
            <tr><td>Tempat/Tgl Lahir</td><td>: {{ $surat->tempat_lahir_ibu }}, {{ \Carbon\Carbon::parse($surat->tanggal_lahir_ibu)->translatedFormat('d-m-Y') }}</td></tr>
            <tr><td>Pekerjaan</td><td>: {{ $surat->pekerjaan_ibu }}</td></tr>
            <tr><td>Agama</td><td>: {{ $surat->agama_ibu }}</td></tr>
            <tr><td>No. KTP</td><td>: {{ $surat->nik_ibu }}</td></tr>
            <tr><td>Alamat</td><td>: {{ $surat->alamat_ibu }}</td></tr>
        </table>

        <p class="indent">
            Nama tersebut di atas benar dilahirkan di {{ $surat->tempat_lahir }} pada hari {{ $surat->hari_lahir }} tanggal {{ \Carbon\Carbon::parse($surat->tanggal_lahir)->translatedFormat('d-m-Y') }} , pukul {{ $surat->waktu_lahir }} WIB.
        </p>

        <p class="indent">
            Demikian surat keterangan ini kami buat dengan penuh tanggung jawab atas kebenarannya.
        </p>

        <div style="width: 100%; text-align: right; margin-top: 40px;">
    <div style="display: inline-block; text-align: center; margin-right: 40px;">
        <p>Ciasmara, {{ $surat->hari }} {{ $surat->tanggal }} {{ $surat->tahun }}</p>
        <p>Kepala Desa</p>
        <img src="{{ public_path('images/ttd.png') }}" alt="Tanda Tangan" style="width: 120px; height: auto; margin: 10px 0;">
        <p><strong><u>JUNAEDI, S.AP</u></strong></p>
    </div>
    </div>

</body>
</html>
