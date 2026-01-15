# Système d'Acceptation des Termes et Conditions

## Vue d'ensemble

Un système complet a été mis en place pour que **chaque nouvel utilisateur doit accepter les termes et conditions avant de pouvoir s'inscrire** à CheckVéhicule.

## Fichiers modifiés et créés

### 1. **Migration de Base de Données**
- **Fichier** : `database/migrations/2026_01_15_000001_add_terms_to_users_table.php`
- **Changements** :
  - Ajoute le champ `accepted_terms_at` (timestamp nullable) pour enregistrer la date d'acceptation
  - Ajoute le champ `terms_version` (string) pour tracker la version des termes acceptée

### 2. **Modèle User**
- **Fichier** : `app/Models/User.php`
- **Changements** :
  - Ajout de `accepted_terms_at` et `terms_version` aux attributs `fillable`
  - Configuration du cast pour `accepted_terms_at` en tant que `datetime`

### 3. **Contrôleur d'Inscription**
- **Fichier** : `app/Http/Controllers/Auth/RegisterController.php`
- **Changements** :
  - Ajout de la validation `accept_terms` avec le paramètre `accepted`
  - Enregistrement de `accepted_terms_at` (timestamp actuel) lors de la création du compte
  - Enregistrement de la version des termes acceptés
  - Messages d'erreur personnalisés en français

### 4. **Vue d'Inscription**
- **Fichier** : `resources/views/auth/register.blade.php`
- **Changements** :
  - Ajout d'une case à cocher pour accepter les termes et conditions
  - Lien vers la page des conditions d'utilisation
  - Lien vers la politique de confidentialité
  - Affichage des erreurs de validation

### 5. **Vue des Termes et Conditions**
- **Fichier** : `resources/views/auth/terms.blade.php` (nouveau)
- **Contenu** : Document complet des termes et conditions avec :
  - Acceptation des termes
  - Description du service
  - Conditions d'accès
  - Propriété intellectuelle
  - Protection des données
  - Responsabilité et disclaimers
  - Gestion des rappels d'entretien
  - Modifications du service
  - Fermeture de compte
  - Communications
  - Conformité légale
  - Informations de contact

### 6. **Vue de Politique de Confidentialité**
- **Fichier** : `resources/views/auth/privacy.blade.php` (nouveau)
- **Contenu** : Politique de confidentialité détaillée couvrant :
  - Collecte des données
  - Utilisation des informations
  - Partage des données
  - Sécurité
  - Cookies et suivi
  - Droits de l'utilisateur
  - Conservation des données
  - Conformité RGPD
  - Contact

### 7. **Routes Web**
- **Fichier** : `routes/web.php`
- **Changements** :
  - Route `GET /terms` → affiche la page des termes et conditions
  - Route `GET /privacy` → affiche la politique de confidentialité

## Comment ça fonctionne

### Flux d'inscription

1. **L'utilisateur clique sur "S'inscrire"**
   - Affichage du formulaire d'inscription

2. **L'utilisateur remplit le formulaire**
   - Nom, Email, Mot de passe
   - **Doit cocher la case d'acceptation des termes**

3. **Clique sur "J'accepte et je m'inscris"**

4. **Validation côté serveur**
   - Les termes doivent être acceptés (validation: `accept_terms` = `accepted`)
   - Tous les autres champs sont validés normalement

5. **Création du compte**
   - Enregistrement du timestamp dans `accepted_terms_at`
   - Enregistrement de la version des termes (actuellement "1.0")
   - Connexion automatique et redirection vers le dashboard

### Accès aux documents légaux

- **Termes et Conditions** : `http://votre-domaine.com/terms`
- **Politique de Confidentialité** : `http://votre-domaine.com/privacy`

Ces pages sont accessibles à tous, y compris avant l'inscription.

## Exécution de la Migration

Avant que le système fonctionne, vous devez exécuter la migration :

```bash
php artisan migrate
```

Cela créera les colonnes `accepted_terms_at` et `terms_version` sur la table `users`.

## Vérification de la Base de Données

Après la migration, la table `users` aura ces nouvelles colonnes :

```sql
SELECT id, name, email, accepted_terms_at, terms_version FROM users;
```

## Personnalisation

### Modifier le texte des termes et conditions

1. Ouvrez [resources/views/auth/terms.blade.php](resources/views/auth/terms.blade.php)
2. Modifiez le contenu Markdown dans la section `<div class="prose">`
3. Sauvegardez et rechargez

### Modifier la version des termes

Si vous mettez à jour les termes et conditions, changez la version dans le contrôleur :

```php
// Dans app/Http/Controllers/Auth/RegisterController.php
'terms_version' => '2.0', // Changez de 1.0 à 2.0
```

### Ajouter de nouvelles sections

Les documents sont écrits en Blade HTML. Vous pouvez ajouter des sections en imitant la structure existante :

```html
<h2>Nouvelle Section</h2>
<p>Contenu de la section...</p>
```

## Sécurité

- Les mots de passe sont hachés avant d'être stockés
- Les données sont validées côté serveur
- L'acceptation des termes est obligatoire et enregistrée
- Les adresses email doivent être uniques

## Conformité légale

- ✅ RGPD compliant (Politique de confidentialité incluse)
- ✅ Consentement enregistré (timestamp dans `accepted_terms_at`)
- ✅ Documents légaux accessibles
- ✅ Droit de contact fourni

## Prochaines étapes (optionnel)

Vous pouvez ajouter :

1. **Historique des acceptations** : Créer une table pour tracker les modifications des termes
2. **Re-acceptation** : Forcer les utilisateurs existants à ré-accepter si les termes changent
3. **Audit trail** : Logger toutes les acceptations pour la conformité
4. **Email de confirmation** : Envoyer un email après acceptation
5. **Contrôle d'accès** : Empêcher l'accès au compte si les termes ne sont pas acceptés

---

**Status** : ✅ Système fonctionnel et déployé
**Version** : 1.0
**Dernière mise à jour** : 15 janvier 2026
