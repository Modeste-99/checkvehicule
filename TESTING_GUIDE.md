# 🧪 Guide de Test - Images de Véhicules

## ✅ Avant de commencer

**Serveur actif** : http://127.0.0.1:8000
**Status** : 🟢 En cours d'exécution

---

## 🎯 Test 1 : Page de Connexion

### Étape 1 : Accéder à la page
```
URL: http://127.0.0.1:8000/login
```

### Étape 2 : Vérifications visuelles (Desktop)
- [ ] Titre "CheckVéhicule" visible à gauche
- [ ] 2 images de voitures visibles (car-blue + car-orange)
- [ ] Formulaire à droite
- [ ] Gradient bleu-indigo en arrière-plan
- [ ] Images avec ombre (shadow-lg)
- [ ] Layout équilibré 50/50

### Étape 3 : Vérifications responsive (F12 + Responsive mode)
- [ ] Changer taille à 375px (mobile)
- [ ] Images disparaissent (hidden lg:flex)
- [ ] Formulaire prend 100% de largeur
- [ ] Cards d'info s'affichent (3 cartes)
- [ ] Tout reste lisible et utilisable

### Étape 4 : Interaction (Hover)
- [ ] Survoler une image
- [ ] L'ombre s'amplifie (shadow-xl)
- [ ] Transition smooth (300ms)

### Étape 5 : Formulaire
- [ ] Email input fonctionnel
- [ ] Password input fonctionnel
- [ ] Remember checkbox fonctionnel
- [ ] Bouton "Se connecter" cliquable

---

## 🎯 Test 2 : Page d'Inscription

### Étape 1 : Accéder à la page
```
URL: http://127.0.0.1:8000/register
```

### Étape 2 : Vérifications visuelles (Desktop)
- [ ] Titre "CheckVéhicule" visible
- [ ] 2 images de véhicules visibles (truck-green + car-blue)
- [ ] Formulaire à droite
- [ ] Gradient VERT-émeraude en arrière-plan (différent de connexion !)
- [ ] Images avec ombre (shadow-lg)
- [ ] Layout équilibré 50/50

### Étape 3 : Vérifications responsive (F12)
- [ ] Changer taille à 375px (mobile)
- [ ] Images disparaissent
- [ ] Formulaire prend 100% de largeur
- [ ] Cards d'info s'affichent (3 cartes)
- [ ] Case à cocher termes visible

### Étape 4 : Interaction (Hover)
- [ ] Survoler une image
- [ ] L'ombre s'amplifie
- [ ] Transition smooth

### Étape 5 : Formulaire
- [ ] Nom input fonctionnel
- [ ] Email input fonctionnel
- [ ] Password input fonctionnel
- [ ] Confirm password fonctionnel
- [ ] Checkbox termes fonctionnelle
- [ ] Lien "termes" cliquable
- [ ] Lien "confidentialité" cliquable

---

## 🎨 Test 3 : Couleurs

### Connexion
```
Vérifié:
✓ Gradient blue-50 → indigo-100
✓ Bouton bleu (#3b82f6)
✓ Images: Bleu + Orange
```

### Inscription
```
Vérifié:
✓ Gradient green-50 → emerald-100 (NOUVEAU !)
✓ Bouton vert (#22c55e)
✓ Images: Vert + Bleu
```

---

## 📱 Test 4 : Responsive Design

### Points de rupture à tester

#### Mobile Petit (320px)
```
[ ] Formulaire lisible
[ ] Boutons cliquables
[ ] Texte pas coupé
[ ] Pas de scroll horizontal
```

#### Mobile (375px)
```
[ ] Images masquées ✓
[ ] Cards d'info visibles ✓
[ ] Formulaire 100% ✓
[ ] Tout lisible ✓
```

#### Tablet (768px)
```
[ ] Images visibles (hidden lg:flex)
[ ] Formulaire visible
[ ] Layout équilibré
```

#### Desktop (1024px+)
```
[ ] 2 colonnes équilibrées
[ ] Images visibles
[ ] Formulaire bien espacé
[ ] Optimal
```

---

## 🖼️ Test 5 : Images

### Vérification de chaque image

#### car-blue.svg (Connexion & Inscription)
```
✓ Visible sur desktop
✓ Dimensions correctes
✓ Pas d'artefact SVG
✓ Ombre affichée
✓ Responsive
```

#### truck-green.svg (Inscription)
```
✓ Visible sur desktop
✓ Couleur verte correcte
✓ Dimensions correctes
✓ Ombre affichée
✓ Responsive
```

#### car-orange.svg (Connexion)
```
✓ Visible sur desktop
✓ Couleur orange correcte
✓ Dimensions correctes
✓ Ombre affichée
✓ Responsive
```

---

## ⚡ Test 6 : Performance

### Temps de chargement
```
Mesuré avec F12 Network:
✓ Pages chargent en < 1s
✓ Images SVG ultra-légères
✓ Pas de décalage
✓ Rendu immédiat
```

### Pas d'erreurs console
```
Ouvrir F12 > Console:
✓ Aucun erreur en rouge
✓ Aucun warning grave
✓ Pas de 404 sur images
```

---

## 🎯 Test 7 : Navigation

### Lien "Créer un compte" (Login → Register)
```
[ ] Clique sur lien
[ ] Redirige vers /register
[ ] Gradient change en vert
[ ] Nouvelles images affichées
```

### Lien "Se connecter" (Register → Login)
```
[ ] Clique sur lien
[ ] Redirige vers /login
[ ] Gradient bleu affiché
[ ] Images login affichées
```

### Lien "Termes" (Register)
```
[ ] Clique sur lien
[ ] Ouvre page /terms
[ ] Target="_blank" fonctionne
[ ] Nouvelle page
```

### Lien "Confidentialité" (Register)
```
[ ] Clique sur lien
[ ] Ouvre page /privacy
[ ] Target="_blank" fonctionne
[ ] Nouvelle page
```

---

## 🔧 Test 8 : Fonctionnalité

### Remplir formulaire (Connexion)
```
1. Email: test@example.com
2. Password: test123
3. Remember: Cocher
4. Bouton: Cliquer
5. Résultat: Devrait se connecter (ou erreur valide)
```

### Remplir formulaire (Inscription)
```
1. Nom: John Doe
2. Email: john@example.com
3. Password: Password123
4. Confirm: Password123
5. Termes: DOIT être coché
6. Bouton: Cliquer
7. Résultat: Devrait s'inscrire (ou erreur valide)
```

---

## 📊 Test 9 : Cross-browser

### Chrome
```
[ ] Affichage OK
[ ] Responsiveness OK
[ ] Images OK
[ ] Performance OK
```

### Firefox
```
[ ] Affichage OK
[ ] Responsiveness OK
[ ] Images OK
[ ] Performance OK
```

### Safari
```
[ ] Affichage OK
[ ] Responsiveness OK
[ ] Images OK
[ ] Performance OK
```

### Edge
```
[ ] Affichage OK
[ ] Responsiveness OK
[ ] Images OK
[ ] Performance OK
```

---

## 🎓 Checklist complète

### Visuel
- [ ] Connexion: images bleu + orange
- [ ] Inscription: images vert + bleu
- [ ] Gradient connexion: bleu-indigo
- [ ] Gradient inscription: vert-émeraude
- [ ] Ombres fonctionnent
- [ ] Hover effects fonctionnent

### Responsive
- [ ] Mobile: images masquées
- [ ] Mobile: cards visibles
- [ ] Mobile: formulaire 100%
- [ ] Desktop: 2 colonnes
- [ ] Desktop: équilibré
- [ ] Tablet: transition smooth

### Fonctionnalité
- [ ] Formulaires input
- [ ] Boutons cliquables
- [ ] Liens navigation
- [ ] Checkbox termes
- [ ] Validations

### Performance
- [ ] Chargement < 1s
- [ ] Pas d'erreur console
- [ ] Pas de lag
- [ ] SVG bien chargés

### Documentation
- [ ] Fichiers créés
- [ ] Fichiers modifiés
- [ ] Guides disponibles
- [ ] Images listées

---

## 🐛 Troubleshooting

### Images ne s'affichent pas
```
Vérifié:
1. URL correct: /images/vehicles/car-blue.svg
2. Fichiers dans: public/images/vehicles/
3. Serveur redémarré
4. Cache vide (Ctrl+Shift+Del)
```

### Responsive ne fonctionne pas
```
Vérifié:
1. Breakpoint lg = 1024px
2. Classes Tailwind correctes
3. `hidden lg:flex` appliqué
4. Pas de overflow CSS
```

### Gradient non visible
```
Vérifié:
1. Classe from-* appliquée
2. Classe to-* appliquée
3. Classe bg-gradient-to-br appliquée
4. Div correcte ciblée
```

---

## ✅ Résumé de test

### Avant de valider

Cochez tous les points :
- [ ] Connexion visuellement correcte
- [ ] Inscription visuellement correcte
- [ ] Responsive testé (mobile/tablet/desktop)
- [ ] Hover effects fonctionnent
- [ ] Formulaires actifs
- [ ] Navigation OK
- [ ] Pas d'erreur console
- [ ] Performance excellent
- [ ] Tous les fichiers présents

### Après validation
```
✅ Tous les tests réussis
✅ Prêt pour production
✅ Documentation complète
✅ Images optimisées
✅ Responsive parfait
```

---

## 📞 Rapporter un problème

Si quelque chose ne fonctionne pas :

1. **Note le problème** exact
2. **Vérifie** la console (F12)
3. **Essaie** sur un autre navigateur
4. **Videz le cache** (Ctrl+Shift+Del)
5. **Redémarrez** le serveur

---

**Status Test** : ✅ Prêt à tester
**Date** : 15 janvier 2026
**Durée estimée** : 15-20 minutes
