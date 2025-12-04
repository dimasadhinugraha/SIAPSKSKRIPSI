<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create dummy family with head
        $family = Family::create([
            'family_name' => 'Keluarga Indana',
            'kk_number' => '3201234567890001',
            'address' => 'Jl. Raya Ciasmara No. 123, RT 05/RW 03',
            'rt' => '05',
            'rw' => '03',
        ]);

        // Create head of family
        $headUser = User::create([
            'name' => 'Shaffira Indana',
            'nik' => '3201234567890001',
            'email' => 'shaffira.indana@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_verified' => true,
            'family_id' => $family->id,
            'is_head_of_family' => true,
        ]);

        // Update family with head_of_family_id
        $family->update([
            'head_of_family_id' => $headUser->id,
        ]);

        // Create biodata for head
        $headUser->biodata()->create([
            'nik' => '3201234567890001',
            'kk_number' => '3201234567890001',
            'address' => 'Jl. Raya Ciasmara No. 123, RT 05/RW 03',
            'phone' => '081234567890',
            'gender' => 'P',
            'birth_date' => '1990-05-15',
            'rt_rw' => 'RT 05/RW 03',
            'rt' => '05',
            'rw' => '03',
            'ktp_photo' => 'documents/dummy-ktp.jpg',
            'kk_photo' => 'documents/dummy-kk.jpg',
        ]);

        // Create another family member (example)
        $memberUser = User::create([
            'name' => 'Ahmad Indana',
            'nik' => '3201234567890002',
            'email' => 'ahmad.indana@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_verified' => true,
            'family_id' => $family->id,
            'is_head_of_family' => false,
        ]);

        $memberUser->biodata()->create([
            'nik' => '3201234567890002',
            'kk_number' => '3201234567890001',
            'address' => 'Jl. Raya Ciasmara No. 123, RT 05/RW 03',
            'phone' => '081234567891',
            'gender' => 'L',
            'birth_date' => '1992-08-20',
            'rt_rw' => 'RT 05/RW 03',
            'rt' => '05',
            'rw' => '03',
            'ktp_photo' => 'documents/dummy-ktp.jpg',
            'kk_photo' => 'documents/dummy-kk.jpg',
        ]);

        // Create another family
        $family2 = Family::create([
            'family_name' => 'Keluarga Wijaya',
            'kk_number' => '3201234567890003',
            'address' => 'Jl. Raya Ciasmara No. 456, RT 02/RW 01',
            'rt' => '02',
            'rw' => '01',
        ]);

        $headUser2 = User::create([
            'name' => 'Budi Wijaya',
            'nik' => '3201234567890003',
            'email' => 'budi.wijaya@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_verified' => true,
            'family_id' => $family2->id,
            'is_head_of_family' => true,
        ]);

        $family2->update([
            'head_of_family_id' => $headUser2->id,
        ]);

        $headUser2->biodata()->create([
            'nik' => '3201234567890003',
            'kk_number' => '3201234567890003',
            'address' => 'Jl. Raya Ciasmara No. 456, RT 02/RW 01',
            'phone' => '081234567892',
            'gender' => 'L',
            'birth_date' => '1985-03-10',
            'rt_rw' => 'RT 02/RW 01',
            'rt' => '02',
            'rw' => '01',
            'ktp_photo' => 'documents/dummy-ktp.jpg',
            'kk_photo' => 'documents/dummy-kk.jpg',
        ]);

        $this->command->info('Families seeded successfully!');
    }
}
