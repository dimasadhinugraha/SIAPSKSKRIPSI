<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;
use App\Models\User;

class TestWhatsAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:whatsapp {phone?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test notifikasi WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('========================================');
        $this->info('📱 Test Sistem Notifikasi WhatsApp');
        $this->info('========================================');
        $this->newLine();

        $whatsapp = app(WhatsAppService::class);

        // Test 1: Check Configuration
        $this->info('🔧 Test 1: Konfigurasi WhatsApp');
        $this->line('-------------------------------------------');
        
        $token = config('services.fonnte.token');
        if ($token) {
            $this->info('✅ FONNTE_TOKEN: ' . substr($token, 0, 10) . '...' . substr($token, -5));
        } else {
            $this->error('❌ FONNTE_TOKEN: Tidak dikonfigurasi');
            $this->newLine();
            $this->displaySetupInstructions();
            return;
        }

        if ($whatsapp->isConfigured()) {
            $this->info('✅ WhatsApp Service: Terkonfigurasi');
        } else {
            $this->error('❌ WhatsApp Service: Tidak terkonfigurasi');
        }
        $this->newLine();

        // Test 2: User dengan nomor telepon
        $this->info('👥 Test 2: User dengan Nomor Telepon');
        $this->line('-------------------------------------------');
        
        $usersWithPhone = User::whereNotNull('phone')
            ->where('phone', '!=', '')
            ->whereIn('role', ['rt', 'rw', 'warga'])
            ->get(['id', 'name', 'phone', 'role']);
        
        if ($usersWithPhone->isEmpty()) {
            $this->warn('⚠️  Tidak ada user dengan nomor telepon');
        } else {
            $this->line('User dengan nomor telepon:');
            foreach ($usersWithPhone->take(5) as $user) {
                $this->line("  • [{$user->role}] {$user->name} - {$user->phone}");
            }
            if ($usersWithPhone->count() > 5) {
                $this->line("  ... dan " . ($usersWithPhone->count() - 5) . " user lainnya");
            }
        }
        $this->newLine();

        // Test 3: Send Test Message
        $phone = $this->argument('phone');
        
        if ($phone) {
            $this->info('📤 Test 3: Mengirim Pesan Test');
            $this->line('-------------------------------------------');
            $this->line("Target: {$phone}");
            $this->newLine();
            
            if ($this->confirm('Kirim pesan test WhatsApp?', true)) {
                $this->info('Mengirim pesan...');
                
                try {
                    $result = $whatsapp->testConnection($phone);
                    
                    if ($result) {
                        $this->info('✅ Pesan berhasil dikirim!');
                        $this->line("Cek WhatsApp di: {$phone}");
                        $this->newLine();
                        $this->displayMessagePreview();
                    } else {
                        $this->error('❌ Gagal mengirim pesan!');
                        $this->newLine();
                        $this->displayTroubleshooting();
                    }
                } catch (\Exception $e) {
                    $this->error('❌ Error: ' . $e->getMessage());
                    $this->line('Cek log: storage/logs/laravel.log');
                }
            }
        } else {
            $this->info('📱 Test 3: Kirim Pesan Test');
            $this->line('-------------------------------------------');
            $this->warn('Nomor telepon tidak diberikan');
            $this->line('Gunakan: php artisan test:whatsapp 628123456789');
        }

        $this->newLine();
        $this->info('========================================');
        $this->info('✅ Test Selesai');
        $this->info('========================================');
        $this->newLine();
        
        $this->displayTips();
    }

    protected function displaySetupInstructions()
    {
        $this->warn('🔧 Cara Setup WhatsApp:');
        $this->newLine();
        $this->line('1. Daftar di https://fonnte.com');
        $this->line('2. Beli paket WhatsApp (mulai Rp 50.000)');
        $this->line('3. Scan QR Code untuk koneksi WhatsApp');
        $this->line('4. Copy API Token dari dashboard');
        $this->line('5. Tambahkan ke .env:');
        $this->line('   FONNTE_TOKEN=your-token-here');
        $this->line('6. Jalankan: php artisan config:clear');
        $this->line('7. Test: php artisan test:whatsapp 628xxx');
        $this->newLine();
    }

    protected function displayMessagePreview()
    {
        $this->comment('📋 Preview pesan yang dikirim:');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->line('🧪 Test Notifikasi WhatsApp');
        $this->newLine();
        $this->line('Ini adalah pesan test dari sistem');
        $this->line('SIAP SK Desa Ciasmara.');
        $this->newLine();
        $this->line('Jika Anda menerima pesan ini,');
        $this->line('berarti konfigurasi WhatsApp');
        $this->line('sudah berhasil! ✅');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->newLine();
    }

    protected function displayTroubleshooting()
    {
        $this->warn('🔍 Kemungkinan penyebab:');
        $this->line('1. Token tidak valid - Generate ulang di Fonnte');
        $this->line('2. Nomor WhatsApp tidak aktif');
        $this->line('3. Saldo Fonnte habis - Top up di dashboard');
        $this->line('4. Format nomor salah (gunakan 628xxx)');
        $this->line('5. Koneksi WhatsApp terputus - Scan ulang QR');
        $this->newLine();
        $this->line('Cek log detail: storage/logs/laravel.log');
        $this->newLine();
    }

    protected function displayTips()
    {
        $this->comment('💡 Tips:');
        $this->line('• Test: php artisan test:whatsapp 628xxx');
        $this->line('• Script: php test-whatsapp.php 628xxx');
        $this->line('• Cek saldo: Login ke fonnte.com');
        $this->line('• Update nomor RT/RW di database');
        $this->line('• Format nomor: 628xxx (tanpa +)');
    }
}
