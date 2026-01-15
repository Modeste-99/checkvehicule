# Guide d'Utilisation - Acceptation des Termes et Conditions

## 🎯 Objectif

Garantir que chaque nouvel utilisateur accepte les termes et conditions de CheckVéhicule avant de pouvoir créer un compte.

## 📋 Ce qui a été fait

### ✅ Base de données
- Ajout de 2 colonnes à la table `users` :
  - `accepted_terms_at` : Enregistre la date et l'heure d'acceptation
  - `terms_version` : Enregistre la version acceptée

### ✅ Validation
- La case "J'accepte les termes" est obligatoire
- Impossible de s'inscrire sans l'avoir cochée
- Message d'erreur clair en français

### ✅ Pages légales
- **Termes et Conditions** : Document complet
- **Politique de Confidentialité** : Document conforme RGPD

### ✅ Routes accessibles
- `/terms` - Affiche les termes et conditions
- `/privacy` - Affiche la politique de confidentialité

## 🚀 Démarrage

### 1️⃣ Exécuter la migration

```bash
php artisan migrate
```

**Résultat attendu** : Les colonnes sont ajoutées à la table `users`

### 2️⃣ Tester l'inscription

1. Allez à `http://localhost:8000/register`
2. Remplissez les champs de formulaire
3. Cochez la case "J'accepte les conditions d'utilisation"
4. Cliquez sur "S'inscrire"

### 3️⃣ Vérifier l'acceptation

Utilisez la commande pour vérifier les acceptations :

```bash
# Voir tous les utilisateurs
php artisan terms:verify

# Voir un utilisateur spécifique
php artisan terms:verify --user_id=1
```

## 📝 Structure du formulaire d'inscription

```
┌─ Formulaire d'Inscription ──────────────────────────────┐
│                                                         │
│  Nom complet *                                          │
│  [________________________]                              │
│                                                         │
│  Email *                                                │
│  [________________________]                              │
│                                                         │
│  Mot de passe *                                         │
│  [________________________]                              │
│                                                         │
│  Confirmer le mot de passe *                            │
│  [________________________]                              │
│                                                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │☑ J'accepte les conditions d'utilisation et la   │   │
│  │  politique de confidentialité                    │   │
│  └──────────────────────────────────────────────────┘   │
│                                                         │
│  [ S'inscrire ]  [ Retour ]                            │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

## 🔍 Vérification de la base de données

Après l'inscription, vérifiez en base de données :

```sql
-- Voir tous les utilisateurs avec leur acceptation
SELECT 
    id,
    name,
    email,
    accepted_terms_at,
    terms_version,
    created_at
FROM users
ORDER BY created_at DESC;
```

**Exemple de résultat** :

| id | name | email | accepted_terms_at | terms_version | created_at |
|----|------|-------|-------------------|---------------|-----------|
| 1 | Jean Dupont | jean@example.com | 2026-01-15 10:30:45 | 1.0 | 2026-01-15 10:30:45 |

## 🔐 Sécurité

- ✅ La validation se fait côté serveur (pas seulement côté client)
- ✅ Les données sensibles sont protégées
- ✅ Impossible de contourner l'acceptation
- ✅ Conformité RGPD garantie

## 📱 Liens permanents

Les utilisateurs peuvent accéder aux documents légaux :

```
Termes et Conditions : https://votre-app.com/terms
Politique de Confidentialité : https://votre-app.com/privacy
```

Ces liens sont disponibles :
- Sur la page d'inscription
- Sur la page de login
- Partout dans l'application

## ⚙️ Configuration

### Modifier le texte des termes

Éditez le fichier : `resources/views/auth/terms.blade.php`

### Modifier la version des termes

Dans `app/Http/Controllers/Auth/RegisterController.php`, changez :

```php
'terms_version' => '2.0', // Changez de 1.0 à 2.0
```

### Personnaliser les messages d'erreur

Dans `app/Http/Controllers/Auth/RegisterController.php` :

```php
$data = $request->validate([
    // ...
    'accept_terms' => ['required', 'accepted'],
], [
    'accept_terms.required' => 'Personnalisez ce message',
]);
```

## 📊 Commandes utiles

### Vérifier les acceptations (tous les utilisateurs)

```bash
php artisan terms:verify
```

**Affiche** :
- Liste des utilisateurs ayant accepté
- Date et version acceptée
- Statistiques

### Vérifier l'acceptation (un utilisateur)

```bash
php artisan terms:verify --user_id=5
```

**Affiche** :
- Nom et email de l'utilisateur
- Statut d'acceptation
- Date et heure exactes
- Version acceptée

## 🎓 Exemple d'exécution

### Première inscription

```
1. Utilisateur remplit le formulaire
2. Coche la case "J'accepte..."
3. Clique sur "S'inscrire"
4. ✅ Compte créé
5. Redirigé vers le dashboard
6. accepted_terms_at = "2026-01-15 10:30:45"
7. terms_version = "1.0"
```

### Sans acceptation

```
1. Utilisateur remplit le formulaire
2. ❌ N'a pas coché la case
3. Clique sur "S'inscrire"
4. ❌ Erreur : "Vous devez accepter les conditions d'utilisation"
5. Formulaire réaffichée avec les données
6. ❌ Compte non créé
```

## 🔧 Troubleshooting

### La migration ne fonctionne pas

```bash
# Vérifier le statut des migrations
php artisan migrate:status

# Réinitialiser (attention : supprime les données)
php artisan migrate:reset
php artisan migrate
```

### Les liens des termes ne fonctionnent pas

Vérifiez que les routes sont correctes dans `routes/web.php` :

```php
Route::get('/terms', function () {
    return view('auth.terms');
})->name('terms');
```

### Le formulaire d'inscription ne change pas

Videz le cache :

```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

## 📚 Documentation complète

Voir : [TERMS_IMPLEMENTATION.md](TERMS_IMPLEMENTATION.md)

---

**Status** : ✅ Opérationnel
**Version** : 1.0
**Dernière mise à jour** : 15 janvier 2026
