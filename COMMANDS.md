# 🚀 COMMANDES ESSENTIELLES - SYSTÈME D'EMAILS

## Démarrage Rapide

### 1️⃣ Configuration (.env)
```bash
# Éditer le fichier .env et configurer :
MAIL_MAILER=log              # Pour tester localement
MAIL_FROM_ADDRESS=noreply@checkvehicule.local
MAIL_FROM_NAME=CheckVéhicule
```

### 2️⃣ Migrer la base de données
```bash
php artisan migrate
```

### 3️⃣ Test rapide (Créer + Envoyer)
```bash
# Crée un rappel de test et l'envoie immédiatement
php artisan rappels:test
```

### 4️⃣ Vérifier les logs
```bash
# Afficher les logs en temps réel
tail -f storage/logs/laravel.log
```

---

## Commandes Essentielles

| Commande | Effet |
|----------|-------|
| `php artisan rappels:test` | Créer + envoyer un rappel de test |
| `php artisan rappels:send` | Envoyer tous les rappels en attente |
| `php artisan test tests/Feature/RappelEmailTest.php` | Exécuter les tests |
| `php artisan tinker` | Console interactive (voir détails ci-dessous) |

---

## Utilisation Tinker

```bash
php artisan tinker

# Voir les rappels à envoyer
Rappel::where('envoye', false)->where('date_rappel', '<=', now())->get();

# Créer un rappel manuellement
Rappel::create([
    'user_id' => 1,
    'vehicule_id' => 1,
    'type' => 'entretien',
    'date_rappel' => now()->subMinutes(1),
    'envoye' => false
]);

# Envoyer tous les rappels
Artisan::call('rappels:send');

exit
```

---

## Développement Local

### Terminal 1 : Serveur Laravel
```bash
php artisan serve
```

### Terminal 2 : File d'attente
```bash
php artisan queue:work --timeout=60
```

### Terminal 3 : Logs en temps réel
```bash
tail -f storage/logs/laravel.log
```

### Terminal 4 : Scheduler (optionnel, pour tester)
```bash
# Exécute le scheduler toutes les minutes
while true; do php artisan schedule:run; sleep 60; done
```

---

## Production

### CRON Job (à ajouter)
```bash
# Exécuter le scheduler Laravel toutes les minutes
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### Vérifier que c'est en place
```bash
crontab -l
```

---

## Debug & Problèmes

### Voir la configuration mail
```bash
php artisan config:show mail
```

### Voir les erreurs
```bash
grep -i error storage/logs/laravel.log
```

### Tester la connexion SMTP
```bash
php artisan mail:send \
  --view='emails.rappel' \
  --markdown
```

### Compter les rappels
```bash
php artisan tinker
Rappel::count();              # Total
Rappel::where('envoye', true)->count();   # Envoyés
Rappel::where('envoye', false)->count();  # En attente
exit
```

---

## Fichiers Importants

```
app/
  ├── Jobs/SendRappelEmail.php              # Envoie l'email
  ├── Console/Commands/
  │   ├── SendRappelReminders.php           # Cherche & envoie
  │   └── TestRappelEmail.php               # Test rapide
  ├── Mail/RappelEmail.php                  # Template email
  └── Notifications/RappelNotification.php  # Notification

resources/views/emails/
  └── rappel.blade.php                      # Design email

config/
  └── mail.php                              # Configuration

.env                                        # Variables d'env

MAIL_IMPLEMENTATION.md                      # Guide complet
RAPPELS_IMPLEMENTATION.md                   # Documentation complète
```

---

## 🎓 Quick Start (5 minutes)

```bash
# 1. Configuration
cp .env.example .env
# → Éditer .env : MAIL_MAILER=log

# 2. Migrer
php artisan migrate

# 3. Serveur
php artisan serve

# 4. Test dans un autre terminal
php artisan rappels:test

# 5. Vérifier
tail -f storage/logs/laravel.log
```

Done ! 🎉

---

## 📞 Aide

Voir les guides détaillés :
- **MAIL_IMPLEMENTATION.md** - Guide pratique complet
- **MAIL_SETUP.md** - Configuration détaillée
- **RAPPELS_IMPLEMENTATION.md** - Documentation complète

Questions ? Utilisez `php artisan tinker` pour déboguer !
