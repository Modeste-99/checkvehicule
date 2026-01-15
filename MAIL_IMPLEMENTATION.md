# 🚀 GUIDE PRATIQUE - MISE EN PLACE DES EMAILS

## 📌 Résumé de l'Implémentation

Vous avez maintenant un **système complet d'envoi d'emails automatique** pour les rappels d'entretien. Voici comment l'utiliser.

---

## 🔧 ÉTAPE 1 : Configuration de Base

### A. Configurer le fichier `.env`

**Option 1 : Pour tester localement (Recommandé)**
```bash
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@checkvehicule.local
MAIL_FROM_NAME=CheckVéhicule
```
Les emails seront enregistrés dans `storage/logs/laravel.log`

**Option 2 : Avec Mailtrap (gratuit, recommandé pour staging)**
1. Inscrivez-vous sur https://mailtrap.io (gratuit)
2. Créez un inbox de test
3. Configurez votre `.env` :
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username
MAIL_PASSWORD=votre_password
MAIL_FROM_ADDRESS=noreply@checkvehicule.local
MAIL_FROM_NAME=CheckVéhicule
```

**Option 3 : Avec Gmail (pour production)**
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=votre_email@gmail.com
MAIL_PASSWORD=votre_mot_de_passe_app
MAIL_FROM_ADDRESS=votre_email@gmail.com
MAIL_FROM_NAME=CheckVéhicule
```
⚠️ Utilisez un [mot de passe d'application](https://myaccount.google.com/apppasswords) pas votre vrai mot de passe

### B. Migrer la base de données (optionnel, pour les index)

```bash
php artisan migrate
```

---

## 🧪 ÉTAPE 2 : Tester le Système

### Test 1 : Créer un rappel de test

```bash
# Ouvrir Tinker
php artisan tinker

# Créer un utilisateur (s'il n'existe pas)
$user = User::factory()->create();

# Créer un véhicule
$vehicule = Vehicule::factory()->create(['user_id' => $user->id]);

# Créer un rappel POUR MAINTENANT (ou il y a 1 minute)
$rappel = Rappel::create([
    'user_id' => $user->id,
    'vehicule_id' => $vehicule->id,
    'type' => 'entretien',
    'date_rappel' => now()->subMinutes(1),
    'notes' => 'Test d\'envoi',
    'envoye' => false
]);

exit
```

### Test 2 : Déclencher l'envoi des rappels

```bash
# Exécuter la commande d'envoi
php artisan rappels:send

# Output attendu :
# Rappel envoyé à user@example.com pour le véhicule [marque] [modèle]
# 1 rappel(s) envoyé(s) avec succès.
```

### Test 3 : Vérifier le log de l'email

```bash
# Afficher les derniers logs
tail -f storage/logs/laravel.log

# Chercher "Rappel envoyé"
grep -i "rappel" storage/logs/laravel.log

# Avec Mailtrap : allez sur votre dashboard Mailtrap
# L'email devrait être visible dans votre inbox de test
```

---

## 🤖 ÉTAPE 3 : Automatiser l'Envoi (Production)

Le système est déjà configuré pour s'exécuter automatiquement avec le **scheduler Laravel**.

### Pour que ça marche, il faut une CRON job :

#### Sur VPS/Linux (cPanel, DirectAdmin, etc.)
```bash
# Ajouter cette ligne en CRON :
* * * * * cd /chemin/vers/votre/projet && php artisan schedule:run >> /dev/null 2>&1
```

#### Sur Shared Hosting
Si vous n'avez pas accès aux CRON :
1. Installez [Laravel Task Scheduler Package](https://github.com/laravel/laravel-scheduler)
2. Ou utilisez un service externe comme [EasyCron](https://www.easycron.com)

#### Sur Heroku
```bash
heroku ps:scale scheduler=1
```

#### Sur Laravel Forge
Le scheduling est automatique ! Pas besoin de configurer la CRON.

---

## 📊 ÉTAPE 4 : Monitorer le Système

### Vérifier les rappels envoyés

```bash
# Via Tinker
php artisan tinker

# Voir les rappels envoyés
Rappel::where('envoye', true)->get();

# Voir les rappels pas encore envoyés
Rappel::where('envoye', false)->get();

# Compter les emails en attente
Rappel::where('envoye', false)->where('date_rappel', '<=', now())->count();

exit
```

### Vérifier les logs

```bash
# Afficher les logs récents
tail -f storage/logs/laravel.log

# Chercher les erreurs d'email
grep -i "error" storage/logs/laravel.log

# Voir seulement les emails envoyés
grep -i "sent" storage/logs/laravel.log
```

---

## 🎯 UTILISATION RÉELLE

### Workflow Utilisateur
1. **L'utilisateur crée un rappel** dans l'interface
   - Remplit : véhicule, type, date/heure, notes
   - Clique "Créer rappel"

2. **Le système sauvegarde le rappel** en BDD avec `envoye = false`

3. **Chaque minute**, la commande `rappels:send` s'exécute et :
   - Cherche les rappels avec `date_rappel <= maintenant && envoye = false`
   - Envoie un email pour chaque rappel trouvé
   - Marque le rappel comme `envoye = true`

4. **L'utilisateur reçoit l'email** avec :
   - Type d'entretien
   - Détails du véhicule
   - Date/heure prévue
   - Notes (si ajoutées)
   - Lien vers ses véhicules

### Personnalisation du Template

Le template se trouve à : `resources/views/emails/rappel.blade.php`

Pour le modifier :
```blade
@component('mail::message')
# Rapel d'entretien

Bonjour {{ $user->name }},
...
@endcomponent
```

---

## 🐛 Troubleshooting

### "SMTP Error: Could not connect to host"
**Solution :**
- Vérifiez votre `MAIL_HOST` et `MAIL_PORT`
- Vérifiez votre firewall
- Testez avec `MAIL_MAILER=log` d'abord

### "Authentication failed for SMTP"
**Solution :**
- Vérifiez `MAIL_USERNAME` et `MAIL_PASSWORD`
- Pour Gmail, utilisez un [mot de passe d'application](https://myaccount.google.com/apppasswords)

### "Aucun rappel à envoyer"
**Causes :**
- Les rappels ont tous `envoye = true`
- Les rappels n'ont pas atteint leur date : `date_rappel > maintenant`
- Pas de rappel créé

**Vérifiez :**
```bash
# Créer un test
php artisan tinker
$rappel = Rappel::create([...,'date_rappel' => now()->subMinutes(1),...]);
php artisan rappels:send
```

### "Le log ne montre rien"
**Solution :**
```bash
# Vérifiez que le log est activé
tail -f storage/logs/laravel.log

# Ou créez une petite commande de test
php artisan tinker
Rappel::where('envoye', false)->where('date_rappel', '<=', now())->count();
```

---

## 📝 Fichiers Créés/Modifiés

| Fichier | Rôle |
|---------|------|
| `app/Jobs/SendRappelEmail.php` | Envoie l'email en arrière-plan |
| `app/Console/Commands/SendRappelReminders.php` | Cherche et déclenche les envois |
| `app/Mail/RappelEmail.php` | Définit le template et le contenu |
| `app/Notifications/RappelNotification.php` | Notification (optionnel) |
| `resources/views/emails/rappel.blade.php` | Template HTML de l'email |
| `database/seeders/RappelSeeder.php` | Données de test |
| `tests/Feature/RappelEmailTest.php` | Tests automatisés |
| `.env.example` | Variables de configuration |

---

## ✅ Checklist de Production

- [ ] Configuration `.env` vérifiée
- [ ] CRON job configuré (ou Laravel Forge/Heroku)
- [ ] Emails testés avec un rappel
- [ ] Template d'email personnalisé
- [ ] Monitoring des logs en place
- [ ] Backup de la base de données configuré
- [ ] Tests automatisés exécutés

```bash
php artisan test tests/Feature/RappelEmailTest.php
```

---

## 🎓 Documentation Complète

Voir [MAIL_SETUP.md](MAIL_SETUP.md) pour plus de détails.

Besoin d'aide ? 📞 Consultez les logs et utilisez `php artisan tinker` pour déboguer !
