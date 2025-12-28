<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Biodata;

class RtUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all RW users
        $rwUsers = User::where('role', 'rw')->orderBy('id')->get();

        // Create 4 RT users for each RW (total 32 RT for 8 RW)
        foreach ($rwUsers as $rwIndex => $rwUser) {
            for ($i = 1; $i <= 4; $i++) {
                $rtNumber = ($rwIndex * 4) + $i;
                $user = User::create([
                    'name' => 'RT ' . str_pad($rtNumber, 2, '0', STR_PAD_LEFT),
                    'email' => 'rt' . str_pad($rtNumber, 2, '0', STR_PAD_LEFT) . '@ciasmara.desa.id',
                    'nik' => '9876543210' . str_pad($rtNumber, 6, '0', STR_PAD_LEFT),
                    'password' => Hash::make('password'),
                    'role' => 'rt',
                ]);

                Biodata::create([
                    'user_id' => $user->id,
                    'rt_rw' => 'RT ' . str_pad($i, 2, '0', STR_PAD_LEFT) . '/' . $rwUser->biodata->rt_rw,
                    'gender' => 'L',
                    'birth_date' => '1975-01-01',
                    'address' => 'Alamat RT ' . str_pad($i, 2, '0', STR_PAD_LEFT) . ' ' . $rwUser->name,
                    'phone' => '08210000' . str_pad($rtNumber, 4, '0', STR_PAD_LEFT),
                    'kk_number' => '32010101' . str_pad($rtNumber, 8, '0', STR_PAD_LEFT),
                    'rw_id' => $rwUser->id, // Link RT to the RW user
                ]);
            }
        }
    }
}
