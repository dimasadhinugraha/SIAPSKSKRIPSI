<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Checking User Dimas ===\n\n";

$user = App\Models\User::where('name', 'like', '%Dimas%')->first();

if ($user) {
    echo "Name: " . $user->name . "\n";
    echo "ID: " . $user->id . "\n";
    echo "Role: " . $user->role . "\n";
    
    if ($user->biodata) {
        echo "RT/RW from biodata: " . $user->biodata->rt_rw . "\n";
    } else {
        echo "No biodata found\n";
    }
    
    echo "\n=== Checking Letter Requests ===\n\n";
    
    $letters = App\Models\LetterRequest::where('user_id', $user->id)->get();
    
    echo "Total letters: " . $letters->count() . "\n\n";
    
    foreach ($letters as $letter) {
        echo "Letter ID: " . $letter->id . "\n";
        echo "Type: " . ($letter->letterType ? $letter->letterType->name : 'N/A') . "\n";
        echo "Status: " . $letter->status . "\n";
        echo "Created: " . $letter->created_at . "\n";
        echo "---\n";
    }
    
    echo "\n=== Checking RT Assignment ===\n\n";
    
    if ($user->biodata && $user->biodata->rt_rw) {
        $rtRwFormat = $user->biodata->rt_rw;
        echo "Looking for RT/RW: " . $rtRwFormat . "\n";
        
        // Parse RT/RW
        $parts = explode('/', $rtRwFormat);
        if (count($parts) == 2) {
            $rt = (int)$parts[0];
            $rw = (int)$parts[1];
            
            $rtRwRecord = App\Models\RtRw::where('rt', $rt)->where('rw', $rw)->first();
            
            if ($rtRwRecord) {
                echo "RT/RW Record found: RT " . $rtRwRecord->rt . " / RW " . $rtRwRecord->rw . "\n";
                
                if ($rtRwRecord->user_id) {
                    $rtUser = App\Models\User::find($rtRwRecord->user_id);
                    if ($rtUser) {
                        echo "Assigned to: " . $rtUser->name . " (Role: " . $rtUser->role . ")\n";
                    }
                } else {
                    echo "No user assigned to this RT/RW\n";
                }
            } else {
                echo "RT/RW record NOT found in rt_rw table\n";
            }
        }
    }
    
} else {
    echo "User not found\n";
}
