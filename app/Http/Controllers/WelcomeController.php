<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\LetterType;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Get latest published news
        $latestNews = News::published()
            ->latest('published_at')
            ->take(6)
            ->get();

        // Get active letter types
        $letterTypes = LetterType::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Village profile data
        $villageProfile = [
            'name' => 'Desa Ciasmara',
            'kecamatan' => 'Pamijahan',
            'kabupaten' => 'Bogor',
            'provinsi' => 'Jawa Barat',
            'kode_pos' => '16810',
            'luas_wilayah' => '12.5 km²',
            'jumlah_penduduk' => '8,542 jiwa',
            'jumlah_kk' => '2,156 KK',
            'kepala_desa' => 'JUNAEDI, S.AP',
            'alamat_kantor' => 'Jl. Raya Ciasmara No. 123, Pamijahan, Bogor',
            'telepon' => '(0251) 123-4567',
            'email' => 'admin@ciasmara.desa.id',
            'website' => 'https://ciasmara.desa.id',
            'jam_pelayanan' => 'Senin - Jumat: 08:00 - 16:00 WIB',
            'visi' => 'Mewujudkan Desa Ciasmara yang Maju, Mandiri, dan Sejahtera',
            'misi' => [
                'Meningkatkan kualitas pelayanan publik yang prima',
                'Mengembangkan potensi ekonomi desa berbasis kearifan lokal',
                'Memperkuat tata kelola pemerintahan yang transparan dan akuntabel',
                'Membangun infrastruktur desa yang berkelanjutan',
                'Memberdayakan masyarakat melalui pendidikan dan pelatihan'
            ],
            'fasilitas' => [
                'Kantor Desa',
                'Balai Desa',
                'Posyandu (3 unit)',
                'Sekolah Dasar (2 unit)',
                'Masjid (5 unit)',
                'Puskesmas Pembantu',
                'Pasar Desa',
                'Lapangan Olahraga'
            ]
        ];

        return view('welcome', compact('latestNews', 'letterTypes', 'villageProfile'));
    }
}
