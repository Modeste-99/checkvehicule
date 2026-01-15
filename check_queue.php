<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Vérifier les jobs en attente
$jobs = DB::table('jobs')->count();
echo "Jobs en attente dans la queue: $jobs\n";

if ($jobs > 0) {
    $data = DB::table('jobs')->limit(5)->get();
    foreach ($data as $job) {
        echo "\nJob ID: {$job->id}\n";
        echo "Payload: " . substr($job->payload, 0, 100) . "...\n";
        echo "Attempts: {$job->attempts}\n";
    }
}
