<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cours;

echo "ID | Titre | Fichier\n";
foreach (Cours::all() as $cours) {
    echo $cours->id . ' | ' . $cours->titre . ' | ' . ($cours->fichier_pdf ?? 'null') . "\n";
}
