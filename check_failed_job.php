<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Récupérer l'erreur du dernier job
$failed = DB::table('failed_jobs')->latest('id')->first();

if ($failed) {
    echo "=== ERREUR DU JOB ÉCHOUÉ ===\n\n";
    echo "ID: {$failed->id}\n";
    echo "Queue: {$failed->queue}\n";
    echo "Failed at: {$failed->failed_at}\n\n";
    echo "Exception:\n";
    echo $failed->exception;
    echo "\n\n";
} else {
    echo "Aucun job échoué trouvé.\n";
}
