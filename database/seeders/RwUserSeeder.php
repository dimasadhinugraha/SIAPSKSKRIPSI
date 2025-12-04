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
        // Create 5 RW users
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'RW ' . $i,
                'email' => 'rw' . $i . '@ciasmara.desa.id',
                'nik' => '123456789012345' . $i,
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
                'is_verified' => true,
                'verified_at' => now(),
            ]);
        }
    }
}
