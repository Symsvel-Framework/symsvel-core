# Intégration continue

Depuis le 22 novembre 2026, la CI s'exécute sur GitHub-hosted Ubuntu 24.04 avec PHP 8.4 et Composer. Les runners privés sont réservés à Packages et Recipes. Le workflow active les tests PHP et PHPUnit ; les crash-tests restent des validations distinctes.

### Visibilité des tests ignorés

La CI affiche les raisons des tests PHPUnit ignorés avec `--display-skipped` (directement ou via le script Composer QA). Un test ignoré ne devient pas bloquant pour autant : les motifs sont examinés pour distinguer prérequis absents et couverture manquante.

## Publication (GitHub-hosted)

Le workflow de publication utilise Ubuntu 24.04 et PHP 8.4. Il valide les tags et crée les GitHub Releases. Aucune publication de test n'a été effectuée pendant la migration.


## Audit des dépendances

Après résolution et installation Composer, `composer audit --locked` doit réussir sans exception dans la CI et dans la validation des releases qui installent les dépendances. PHPUnit doit être au minimum en 13.4.4. Un audit vert ne remplace ni les tests ni le CT.
