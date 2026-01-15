#!/bin/bash

# Script de vérification de l'implémentation des emails

echo "═════════════════════════════════════════════════════════"
echo "  VÉRIFICATION - SYSTÈME D'ENVOI D'EMAILS"
echo "═════════════════════════════════════════════════════════"
echo ""

# Couleurs
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

check_file() {
    if [ -f "$1" ]; then
        echo -e "${GREEN}✅${NC} $1"
        return 0
    else
        echo -e "${RED}❌${NC} $1"
        return 1
    fi
}

check_directory() {
    if [ -d "$1" ]; then
        echo -e "${GREEN}✅${NC} $1/"
        return 0
    else
        echo -e "${RED}❌${NC} $1/"
        return 1
    fi
}

count=0
total=0

echo "📁 VÉRIFICATION DES FICHIERS CRÉÉS"
echo ""

total=$((total + 1))
if check_file "app/Jobs/SendRappelEmail.php"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "app/Console/Commands/SendRappelReminders.php"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "app/Console/Commands/TestRappelEmail.php"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "app/Mail/RappelEmail.php"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "app/Notifications/RappelNotification.php"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "resources/views/emails/rappel.blade.php"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "database/seeders/RappelSeeder.php"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "database/migrations/2026_01_15_000000_add_indexes_to_rappels_table.php"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "tests/Feature/RappelEmailTest.php"; then count=$((count + 1)); fi

echo ""
echo "📚 DOCUMENTATION"
echo ""

total=$((total + 1))
if check_file "MAIL_SETUP.md"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "MAIL_IMPLEMENTATION.md"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "RAPPELS_IMPLEMENTATION.md"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "COMMANDS.md"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "IMPLEMENTATION_COMPLETE.md"; then count=$((count + 1)); fi

total=$((total + 1))
if check_file "IMPLEMENTATION_SUMMARY.json"; then count=$((count + 1)); fi

echo ""
echo "🛠️  UTILITAIRES"
echo ""

total=$((total + 1))
if check_file "rappels-helper.sh"; then count=$((count + 1)); fi

echo ""
echo "═════════════════════════════════════════════════════════"
echo "RÉSULTAT : $count/$total fichiers trouvés"
echo "═════════════════════════════════════════════════════════"
echo ""

if [ $count -eq $total ]; then
    echo -e "${GREEN}✅ IMPLÉMENTATION COMPLÈTE !${NC}"
    echo ""
    echo "Prochaines étapes :"
    echo "1. Éditer .env : MAIL_MAILER=log"
    echo "2. Exécuter : php artisan migrate"
    echo "3. Tester : php artisan rappels:test"
    echo ""
    exit 0
else
    echo -e "${YELLOW}⚠️  $((total - count)) fichier(s) manquant(s)${NC}"
    exit 1
fi
