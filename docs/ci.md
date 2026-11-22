# Intégration continue

Depuis le 22/11/2026, la CI active `.github/workflows/ci.yml` est exécutée sur **GitHub-hosted Ubuntu 24.04**, avec PHP 8.4 installé par `shivammathur/setup-php@v2`, Composer et les tests existants. Les `push` vers `dev` et `main`, ainsi que les PR vers `main`, déclenchent la CI. `ci.yml.stub` reste une archive inactive.

Les runners du mainteneur ne servent plus ces dépôts publics : ils restent réservés à `symsvel-packages` et `symsvel-recipes` (privés). CI et crash-tests restent des validations distinctes.

### Visibilité des tests ignorés

La CI affiche les raisons des tests PHPUnit ignorés avec `--display-skipped` (directement ou via le script Composer QA). Un test ignoré ne devient pas bloquant pour autant : les motifs sont examinés pour distinguer prérequis absents et couverture manquante.

## Releases sur GitHub-hosted (22/11/2026)

`.github/workflows/release.yml` publie les tags `vX.Y.Z` via GitHub-hosted Ubuntu 24.04 (PHP 8.4 / Composer installés dans le workflow). Les contrôles existants, la vérification du tag et la création de la GitHub Release restent inchangés. Une publication réelle doit encore être vérifiée.

