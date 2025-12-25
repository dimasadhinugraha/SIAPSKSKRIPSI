<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CleanInvalidSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:clean-invalid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean sessions with invalid user IDs that no longer exist in the users table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Cleaning invalid sessions...');

        // Get all valid user IDs
        $validUserIds = User::pluck('id')->toArray();
        
        if (empty($validUserIds)) {
            $this->warn('No users found in the database!');
            return 0;
        }

        $this->info('Found ' . count($validUserIds) . ' valid user(s)');

        // Find and delete sessions with invalid user_ids
        $deleted = DB::table('sessions')
            ->whereNotNull('user_id')
            ->whereNotIn('user_id', $validUserIds)
            ->delete();

        if ($deleted > 0) {
            $this->info("✓ Deleted {$deleted} invalid session(s)");
        } else {
            $this->info('✓ No invalid sessions found');
        }

        return 0;
    }
}
