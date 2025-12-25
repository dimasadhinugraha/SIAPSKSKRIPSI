<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== All RT/RW Records ===\n\n";

$rtRws = App\Models\RtRw::all();

foreach ($rtRws as $rtRw) {
    echo "RT: " . $rtRw->rt . " / RW: " . $rtRw->rw . "\n";
    echo "Format: " . $rtRw->rt_rw_format . "\n";
    
    if ($rtRw->user_id) {
        $user = App\Models\User::find($rtRw->user_id);
        if ($user) {
            echo "Assigned to: " . $user->name . " (" . $user->role . ")\n";
        }
    } else {
        echo "No assignment\n";
    }
    echo "---\n";
}

echo "\n=== All Users with RT/RW in Biodata ===\n\n";

$users = App\Models\User::with('biodata')->whereHas('biodata', function($q) {
    $q->whereNotNull('rt_rw');
})->get();

foreach ($users as $user) {
    echo "User: " . $user->name . "\n";
    echo "RT/RW in biodata: " . $user->biodata->rt_rw . "\n";
    echo "---\n";
}
