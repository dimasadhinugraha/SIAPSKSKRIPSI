<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\LetterType;
use App\Models\LetterRequest;
use Illuminate\Console\Command;

class CreateDemoLetterRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:create-letter-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create demo letter requests for testing workflow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating demo letter requests...');

        // Get test user
        $user = User::where('email', 'warga@example.com')->first();
        if (!$user) {
            $this->error('Test user not found. Please run database seeder first.');
            return 1;
        }

        // Get letter types
        $letterTypes = LetterType::all();
        if ($letterTypes->isEmpty()) {
            $this->error('No letter types found. Please run database seeder first.');
            return 1;
        }

        $requests = [];

        // Create different types of requests
        foreach ($letterTypes as $index => $letterType) {
            $requestNumber = 'DEMO-' . date('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            $formData = [];
            if ($letterType->required_fields) {
                foreach ($letterType->required_fields as $field => $type) {
                    switch ($field) {
                        case 'keperluan':
                            $formData[$field] = 'Demo keperluan untuk ' . $letterType->name;
                            break;
                        case 'alamat_domisili':
                            $formData[$field] = 'RT 01/RW 01 Desa Ciasmara';
                            break;
                        case 'kepolisian_tujuan':
                            $formData[$field] = 'Polres Setempat';
                            break;
                        case 'nama_usaha':
                            $formData[$field] = 'Warung Demo';
                            break;
                        case 'jenis_usaha':
                            $formData[$field] = 'Perdagangan';
                            break;
                        case 'alamat_usaha':
                            $formData[$field] = 'RT 01/RW 01 Desa Ciasmara';
                            break;
                        case 'modal_usaha':
                            $formData[$field] = 5000000;
                            break;
                        default:
                            $formData[$field] = 'Demo data untuk ' . $field;
                    }
                }
            }

            $letterRequest = LetterRequest::create([
                'request_number' => $requestNumber,
                'user_id' => $user->id,
                'letter_type_id' => $letterType->id,
                'form_data' => $formData,
                'status' => 'pending_rt',
                'submitted_at' => now(),
            ]);

            $requests[] = $letterRequest;
            $this->info("Created: {$requestNumber} - {$letterType->name}");
        }

        $this->info("\nDemo letter requests created successfully!");
        $this->info("You can now:");
        $this->info("1. Login as RT (rt01@ciasmara.desa.id) to approve RT level");
        $this->info("2. Login as RW (rw01@ciasmara.desa.id) to approve RW level");
        $this->info("3. Login as User (warga@example.com) to see status and download PDF");

        return 0;
    }
}
