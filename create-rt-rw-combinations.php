<?php

use Illuminate\Support\Facades\DB;

// Create all RT/RW combinations
for ($rw = 1; $rw <= 11; $rw++) {
    for ($rt = 1; $rt <= 34; $rt++) {
        DB::table('rt_rw')->insert([
            'rt' => $rt,
            'rw' => $rw,
            'user_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

echo "Created 374 RT/RW combinations\n";
