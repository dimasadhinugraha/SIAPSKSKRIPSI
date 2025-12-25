<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$rtRwList = App\Models\RtRw::orderBy('rw')->orderBy('rt')->get();

echo "Total RT/RW: " . $rtRwList->count() . "\n\n";

foreach ($rtRwList as $rtRw) {
    echo "RT: " . $rtRw->rt . " / RW: " . $rtRw->rw . "\n";
    echo "Format: " . $rtRw->rt_rw_format . "\n\n";
}
