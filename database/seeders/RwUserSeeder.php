<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Biodata;

class RwUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 8 RW users
        for ($i = 1; $i <= 8; $i++) {
            $user = User::create([
                'name' => 'RW ' . $i,
                'email' => 'rw' . $i . '@ciasmara.desa.id',
                'nik' => '1234567890' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'role' => 'rw',
            ]);

            Biodata::create([
                'user_id' => $user->id,
                'rt_rw' => 'RW ' . $i,
                'gender' => 'L',
                'birth_date' => '1970-01-01',
                'address' => 'Alamat RW ' . $i,
                'phone' => '0812000000' . $i,
                'kk_number' => '32010101010000' . $i,
            ]);
        }
    }
}
