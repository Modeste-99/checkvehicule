# 📧 GUIDE: Dépannage et Configuration du Système d'Emails - CheckVéhicule

## 🎯 Résumé de la Situation

**Problème**: Un utilisateur a créé un rappel mais n'a pas reçu d'email  
**Diagnostic**: Le système fonctionne correctement! ✅  
**Cause**: La commande d'envoi n'était pas exécutée automatiquement  
**Solution**: Démarrer le Scheduler Laravel

---

## 🔍 Diagnostic Effectué

Voici ce qui a été vérifié:

```
✅ Configuration mail: MAIL_MAILER=log (développement)
✅ Total rappels: 3
✅ Rappels envoyés: 2
✅ Rappels en attente: 1
✅ Commande d'envoi: php artisan rappels:send ✓ FONCTIONNE
```

### État des Rappels:
- **Rappel #1** → Envoyé à gaga@gmail.com ✅
- **Rappel #6** → Envoyé à modestedan771@gmail.com ✅
- **Rappel #3** → En attente (date: 2026-01-16, futur)

---

## 🚀 Configuration pour Automatiser les Emails

### Option 1: Pour le Développement (Recommandé)

Démarrez le scheduler en continu:

```bash
php artisan schedule:work
```

Cela va:
- Exécuter la commande d'envoi toutes les minutes
- Vérifier les rappels dont la date est arrivée
- Envoyer les emails automatiquement
- Continuer à s'exécuter même après la fermeture du terminal (avec &)

Pour le mode background:
```bash
php artisan schedule:work &
```

### Option 2: Exécution Manuelle

Si vous n'avez pas le scheduler en continu:

```bash
php artisan rappels:send
```

Exécutez cette commande:
- Quand vous le souhaitez
- Ou via une tâche cron (voir ci-dessous)

### Option 3: Pour la Production (Cron)

Ajoutez une seule ligne à votre crontab:

```bash
*/1 * * * * cd /chemin/vers/checkvehicule && php artisan schedule:run >> /dev/null 2>&1
```

Cela exécutera le scheduler chaque minute (même que `schedule:work` mais pour production).

---

## 📋 Commandes Utiles

```bash
# Voir le diagnostic complet
php artisan diagnose:email

# Envoyer les rappels immédiatement
php artisan rappels:send

# Afficher le statut du scheduler
php artisan scheduler:status

# Démarrer le scheduler en continu
php artisan schedule:work

# Tester un rappel spécifique
php artisan tinker
>>> $rappel = App\Models\Rappel::find(6);
>>> $rappel->envoye = false;
>>> $rappel->save();
>>> exit
php artisan rappels:send
```

---

## 🔧 Configuration du Mail (.env)

Actuellement configuré en mode développement:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Pour Tester avec Gmail:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-applicatif
MAIL_FROM_ADDRESS=votre-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Note**: Google nécessite un "mot de passe d'application" (app password), pas votre mot de passe principal.

### Pour Tester avec Mailtrap:

1. Créez un compte sur [Mailtrap.io](https://mailtrap.io)
2. Configurez:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_ENCRYPTION=tls
MAIL_USERNAME=votre-username
MAIL_PASSWORD=votre-password
```

---

## 📊 Structure du Système d'Emails

```
User crée un Rappel
      ↓
  Rappel stocké en BD
  (envoye = false, date_rappel = date future)
      ↓
Scheduler (toutes les minutes)
      ↓
SendRappelReminders Command
  Cherche: WHERE envoye = false AND date_rappel <= NOW()
      ↓
SendRappelEmail Job (async)
  Envoie l'email via RappelEmail Mailable
  Marque: envoye = true
      ↓
Email reçu par l'utilisateur ✅
```

---

## ✅ Checklist: Vérifier que le Système Fonctionne

- [ ] Créer un rappel avec une date dans le futur
- [ ] Exécuter `php artisan schedule:work`
- [ ] Attendre 1-2 minutes
- [ ] Vérifier les logs: `storage/logs/laravel.log`
- [ ] Chercher: `Rappel envoyé à [email]`
- [ ] Vérifier la BD: `php artisan tinker` → `App\Models\Rappel::all()`
- [ ] Confirmer: colonne `envoye = true`

---

## 🐛 Dépannage

### Problème: "Pas d'emails reçus"

**Vérifier:**

```bash
# 1. Le scheduler fonctionne?
ps aux | grep "schedule:work"

# 2. Les rappels sont créés?
php artisan tinker
>>> App\Models\Rappel::where('envoye', false)->get()

# 3. La date est passée?
>>> $rappel = App\Models\Rappel::find(6);
>>> $rappel->date_rappel;  // Doit être <= now()

# 4. Exécuter manuellement
php artisan rappels:send

# 5. Vérifier les logs
tail -f storage/logs/laravel.log
```

### Problème: "Erreur lors de l'envoi"

```bash
# Vérifier la configuration mail
cat .env | grep MAIL_

# Tester la connexion SMTP
php artisan tinker
>>> Mail::raw('Test', function($m) { $m->to('test@test.com'); });
```

---

## 📝 Notes Importantes

1. **MAIL_MAILER=log**: En mode log, les emails sont écrits dans `storage/logs/laravel.log`, pas envoyés réellement
2. **Scheduler en continu**: Nécessite que `php artisan schedule:work` soit actif
3. **Sans scheduler**: Vous devez exécuter manuellement `php artisan rappels:send` ou configurer cron
4. **Date du rappel**: Doit être `>= now()` pour être envoyé (validation: `'date_rappel' => 'required|date'`)

---

## 🎓 Résumé pour les Utilisateurs

Dites aux utilisateurs:

> "Quand vous créez un rappel avec une date future, un email sera automatiquement envoyé à la date définie. Assurez-vous que le serveur d'application est en cours d'exécution pour que les emails soient envoyés à temps."

---

**Dernier test**: ✅ 2 emails envoyés avec succès  
**Date**: 2026-01-15 09:10  
**Commande**: `php artisan rappels:send`

