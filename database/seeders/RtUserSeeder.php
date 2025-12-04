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
        // Find the first RW user to associate RTs with
        $rwUser = User::where('role', 'rw')->orderBy('id')->first();

        if ($rwUser) {
            // Create 2 RT users for the first RW
            for ($i = 1; $i <= 2; $i++) {
                $user = User::create([
                    'name' => 'RT ' . $i . ' / ' . $rwUser->name,
                    'email' => 'rt' . $i . str_replace(' ', '', $rwUser->name) . '@ciasmara.desa.id',
                    'nik' => '987654321098765' . $i,
                    'password' => Hash::make('password'),
                    'role' => 'rt',
                ]);

                Biodata::create([
                    'user_id' => $user->id,
                    'rt_rw' => 'RT ' . $i . '/' . $rwUser->biodata->rt_rw,
                    'gender' => 'L',
                    'birth_date' => '1975-01-01',
                    'address' => 'Alamat RT ' . $i . ' ' . $rwUser->name,
                    'phone' => '0821000000' . $i,
                    'kk_number' => '32010101010009' . $i,
                    'is_verified' => true,
                    'verified_at' => now(),
                    'rw_id' => $rwUser->id, // Link RT to the RW user
                ]);
            }
        }
    }
}
