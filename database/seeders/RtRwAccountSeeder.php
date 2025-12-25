<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Biodata;
use App\Models\RtRw;

class RtRwAccountSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create 11 RW accounts (RW 1-11)
        $this->command->info("Creating RW accounts...");
        for ($rw = 1; $rw <= 11; $rw++) {
            $rwNumber = str_pad($rw, 3, '0', STR_PAD_LEFT);
            $nik = '3201' . str_pad($rw, 12, '0', STR_PAD_LEFT);
            
            $user = User::create([
                'name' => "Ketua RW {$rwNumber}",
                'nik' => $nik,
                'email' => "rw{$rwNumber}@siappsk.local",
                'password' => Hash::make('password123'),
                'role' => 'rw',
                'is_verified' => true,
                'is_approved' => true,
                'email_verified_at' => now(),
            ]);

            Biodata::create([
                'user_id' => $user->id,
                'gender' => 'L',
                'birth_date' => '1975-01-01',
                'address' => "Jl. Utama RW {$rwNumber}, Desa Ciasmara",
                'phone' => '08' . str_pad($rw, 10, '0', STR_PAD_LEFT),
                'kk_number' => '3201' . str_pad($rw + 100, 12, '0', STR_PAD_LEFT),
                'rt_rw' => "000/{$rwNumber}",
            ]);

            $this->command->info("Created RW {$rwNumber} (ID: {$user->id}) - {$user->email}");
        }

        // Create 34 RT accounts (RT 1-34)
        $this->command->info("\nCreating RT accounts...");
        for ($rt = 1; $rt <= 34; $rt++) {
            $rtNumber = str_pad($rt, 3, '0', STR_PAD_LEFT);
            $nik = '3202' . str_pad($rt, 12, '0', STR_PAD_LEFT);
            
            $user = User::create([
                'name' => "Ketua RT {$rtNumber}",
                'nik' => $nik,
                'email' => "rt{$rtNumber}@siappsk.local",
                'password' => Hash::make('password123'),
                'role' => 'rt',
                'is_verified' => true,
                'is_approved' => true,
                'email_verified_at' => now(),
            ]);

            Biodata::create([
                'user_id' => $user->id,
                'gender' => 'L',
                'birth_date' => '1980-01-01',
                'address' => "Jl. RT {$rtNumber}, Desa Ciasmara",
                'phone' => '08' . str_pad($rt + 100, 10, '0', STR_PAD_LEFT),
                'kk_number' => '3202' . str_pad($rt + 200, 12, '0', STR_PAD_LEFT),
                'rt_rw' => "{$rtNumber}/000",
            ]);

            $this->command->info("Created RT {$rtNumber} (ID: {$user->id}) - {$user->email}");
        }

        $this->command->info("\n==============================================");
        $this->command->info("Selesai! Total akun yang dibuat:");
        $this->command->info("- 11 akun RW (rw001@siappsk.local - rw011@siappsk.local)");
        $this->command->info("- 34 akun RT (rt001@siappsk.local - rt034@siappsk.local)");
        $this->command->info("Password untuk semua akun: password123");
        $this->command->info("==============================================\n");
    }
}
