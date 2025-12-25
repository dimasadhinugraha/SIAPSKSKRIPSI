<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:delete-unverified';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users who have not been verified within 3 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threeDaysAgo = Carbon::now()->subDays(3);
        
        // Find users who are not verified and registered more than 3 days ago
        $unverifiedUsers = User::where('is_verified', false)
            ->where('is_approved', false)
            ->where('created_at', '<=', $threeDaysAgo)
            ->get();

        $count = $unverifiedUsers->count();

        if ($count === 0) {
            $this->info('No unverified users found to delete.');
            return 0;
        }

        foreach ($unverifiedUsers as $user) {
            // Delete related biodata and files
            if ($user->biodata) {
                // Delete KTP photo
                if ($user->biodata->ktp_photo) {
                    \Storage::disk('public')->delete($user->biodata->ktp_photo);
                }
                
                // Delete KK photo
                if ($user->biodata->kk_photo) {
                    \Storage::disk('public')->delete($user->biodata->kk_photo);
                }
                
                // Delete profile photo
                if ($user->biodata->profile_photo) {
                    \Storage::disk('public')->delete($user->biodata->profile_photo);
                }
                
                $user->biodata->delete();
            }
            
            // Delete the user
            $user->delete();
            
            $this->info("Deleted user: {$user->name} (NIK: {$user->nik})");
        }

        $this->info("Successfully deleted {$count} unverified user(s).");
        
        return 0;
    }
}
