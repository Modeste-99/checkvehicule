# 📧 SYSTÈME D'ENVOI D'EMAILS POUR LES RAPPELS

## ✅ Implémentation Complète

Voici ce qui a été mis en place pour l'envoi automatique d'emails :

### 📁 Fichiers Créés/Modifiés

1. **`app/Jobs/SendRappelEmail.php`** - Job de file d'attente pour envoyer les emails
2. **`app/Console/Commands/SendRappelReminders.php`** - Commande Artisan pour chercher et envoyer les rappels
3. **`app/Mail/RappelEmail.php`** - Classe Mailable améliorée avec les bonnes données
4. **`app/Notifications/RappelNotification.php`** - Notification pour les rappels (optionnel)
5. **`resources/views/emails/rappel.blade.php`** - Template d'email amélioré
6. **`.env.example`** - Configuration mise à jour avec paramètres mail

### ⚙️ Configuration Requise

#### 1. Configurer votre fichier `.env`

```bash
# Pour développement local (logs seulement)
MAIL_MAILER=log

# OU Pour production avec SMTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com (ou votre provider)
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=votre_email@gmail.com
MAIL_PASSWORD=votre_mot_de_passe
MAIL_FROM_ADDRESS=noreply@checkvehicule.fr
MAIL_FROM_NAME=CheckVéhicule

# OU Utiliser Mailtrap pour les tests
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username_mailtrap
MAIL_PASSWORD=votre_password_mailtrap
MAIL_FROM_ADDRESS=noreply@checkvehicule.local
MAIL_FROM_NAME=CheckVéhicule
```

#### 2. Configurer la file d'attente

Par défaut, la file d'attente est configurée en base de données (`QUEUE_CONNECTION=database`).

Si vous voulez utiliser le mode synchrone (direct) pour les tests :
```bash
QUEUE_CONNECTION=sync
```

### 🚀 Comment Ça Marche

#### 1. Flux d'Envoi
```
Utilisateur crée un rappel
    ↓
Rappel sauvegardé en BDD avec envoye=false
    ↓
Cron job/Scheduler exécute: php artisan rappels:send
    ↓
Recherche les rappels dont date_rappel <= maintenant && envoye=false
    ↓
Dispatch SendRappelEmail Job pour chaque rappel
    ↓
Job envoie l'email à l'utilisateur
    ↓
Marque le rappel comme envoye=true
```

#### 2. Scheduling Automatique

Le fichier `app/Console/Kernel.php` exécute la commande toutes les minutes :
```php
$schedule->command('rappels:send')
         ->everyMinute()
         ->withoutOverlapping()
         ->onOneServer()
         ->runInBackground();
```

**Pour que cela fonctionne en production, vous devez configurer une CRON :**

```bash
* * * * * cd /path/to/checkvehicule && php artisan schedule:run >> /dev/null 2>&1
```

Ou utiliser un service comme Laravel Forge/Vapor qui gère ça automatiquement.

### 🧪 Tests Locaux

#### Méthode 1 : Avec le mailer 'log'
```bash
# Dans .env
MAIL_MAILER=log

# Les emails seront écrits dans storage/logs/laravel.log
tail -f storage/logs/laravel.log
```

#### Méthode 2 : Avec Mailtrap
1. Créez un compte gratuit sur [https://mailtrap.io](https://mailtrap.io)
2. Copiez vos credentials dans `.env`
3. Allez dans le dashboard pour voir les emails reçus

#### Méthode 3 : Tester manuellement
```bash
# Créer un rappel pour maintenant (ou un moment proche)
php artisan tinker

# Puis exécuter :
$rappel = Rappel::create([
    'user_id' => 1,
    'vehicule_id' => 1,
    'type' => 'entretien',
    'date_rappel' => now(),
    'notes' => 'Test email'
]);

# Exécuter la commande d'envoi
\Illuminate\Support\Facades\Artisan::call('rappels:send');

# Vérifier le log
exit
tail -f storage/logs/laravel.log
```

### 📝 Structure du Template Email

Le template `resources/views/emails/rappel.blade.php` contient :
- Titre avec type de rappel
- Salutation personnalisée
- Détails du véhicule
- Détails du rappel
- Bouton d'action pour accéder aux véhicules
- Footer avec copyright

### 🔧 Personnalisation

#### Pour modifier l'apparence de l'email :
```bash
# Générer les templates mail
php artisan vendor:publish --tag=laravel-mail
```

#### Pour changer la fréquence d'envoi :
Modifiez `app/Console/Kernel.php` :
```php
$schedule->command('rappels:send')
         ->everyFiveMinutes()  // Au lieu de everyMinute()
         ->withoutOverlapping()
         ->onOneServer()
         ->runInBackground();
```

### 📊 Monitoring

#### Vérifier les rappels envoyés
```bash
# Base de données
SELECT * FROM rappels WHERE envoye = true ORDER BY updated_at DESC;
```

#### Vérifier les logs
```bash
# En local
tail -f storage/logs/laravel.log | grep -i rappel

# En production
journalctl -u laravel-queue -f
```

#### Erreurs courantes

1. **"SMTP host not configured"**
   - Vérifiez que `MAIL_MAILER=log` ou que vos credentials SMTP sont corrects

2. **"Rappels envoyés 0 fois"**
   - Vérifiez que la date du rappel est passée : `date_rappel <= now()`
   - Vérifiez que `envoye = false` en BDD

3. **"Connection timeout"**
   - Vérifiez votre firewall
   - Testez avec `MAIL_MAILER=log` d'abord

### 🎯 Prochaines Étapes Possibles

- [ ] Ajouter des rappels multiples (1 jour avant, 1 semaine avant)
- [ ] Ajouter des préférences de notifications par utilisateur
- [ ] Créer des notifications in-app en plus des emails
- [ ] Ajouter un système de retry en cas d'erreur
- [ ] Créer un dashboard pour voir l'historique des emails envoyés
- [ ] Ajouter un PDF en pièce jointe avec l'historique d'entretien

### 📞 Support

Pour tester le système complet :
```bash
# 1. Démarrer Laravel
php artisan serve

# 2. Dans un autre terminal, écouter la file d'attente
php artisan queue:work --timeout=60

# 3. Créer un rappel
php artisan tinker
# ... créer un rappel ...

# 4. Vérifier les logs
tail -f storage/logs/laravel.log
```
