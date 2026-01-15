<?php

$smtp_host = 'sandbox.smtp.mailtrap.io';
$smtp_port = 587;

echo "Test de connexion SMTP...\n";
echo "Host: $smtp_host\n";
echo "Port: $smtp_port\n\n";

$fp = @fsockopen($smtp_host, $smtp_port, $errno, $errstr, 10);

if ($fp) {
    echo "✅ Connexion SMTP: SUCCESS\n";
    echo "Serveur SMTP répond!\n";
    fclose($fp);
} else {
    echo "❌ Connexion SMTP: FAILED\n";
    echo "Erreur: $errstr (Code: $errno)\n";
}
