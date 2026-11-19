# SymSvel Core

Bundle Symfony de runtime technique : package Composer `symsvel-framework/core`.

Le dépôt contient actuellement :

- `src/SymSvelCoreBundle.php` : bundle Symfony activable dans l'application ;
- `src/Http/ApiResponse.php` : construction de réponses API selon le contrat du framework ;
- `tests/BundleTest.php` et `tests/ApiResponseTest.php` : tests associés.

Le Core reste volontairement léger : les fonctions applicatives, données métier, pages et règles propres aux domaines appartiennent aux modules. Les opérations d'installation, de mise à jour, de migrations et de maintenance relèvent de la CLI et du Tooling, pas du runtime Core.

Voir [les responsabilités des composants](https://github.com/Symsvel-Framework/symsvel-back/blob/main/docs/architecture/composants.md) et [le contrat de réponses API](https://github.com/Symsvel-Framework/symsvel-back/blob/main/docs/api-contract.md).

Cette description porte sur le code présent dans ce dépôt ; elle ne présume pas de futures extractions du Back.

## CI locale et CI GitHub de référence (10/11/2026)

Le workflow actif `.github/workflows/ci.yml` s'exécute sur le runner d'organisation Docker ARM64 (`self-hosted`, `linux`, `ARM64`, `symsvel`). Il utilise PHP 8.4 et Composer déjà présents dans l'image, puis conserve la validation Composer, l'installation des dépendances, le lint PHP et PHPUnit. Le workflow GitHub-hosted d'origine (`ubuntu-24.04` et `shivammathur/setup-php@v2`) est sauvegardé, désactivé, dans `.github/workflows/ci.yml.stub` ; restaurer son contenu dans `ci.yml` pour revenir au runner GitHub. Ne pas activer les deux variantes simultanément pour préserver les minutes hébergées. L'exécution dépend de la disponibilité du Mac et de Docker ; ce runner persistant doit être réservé aux contributions de confiance. CI verte et crash-tests requis avant validation finale.

## Liveness HTTP natif (19/11/2026)

Core fournit `SymSvel\\Core\\Controller\\HealthController` pour le
point d'entrée `GET /api/health`. Le contrat public utilise
`ApiResponse::success(['status' => 'ok'])` et `Cache-Control: no-store` :
`{"data":{"status":"ok"}}`. Aucune base, cache, transport mail, queue ou
module métier n'est interrogé. Un succès signifie **uniquement** que
le routeur Symfony a pu exécuter cette action ; il ne garantit pas la
disponibilité des autres services (readiness à traiter séparément).

Le contrôleur et son service sont propres au Core et ne créent pas de
nouveau module. **Intégration requise côté Back :** importer les
attributs depuis `vendor/symsvel-framework/core/src/Controller/` après
publication / mise à jour de Core, sans réintroduire de registre généré.
Les tests Core portent sur le contrat JSON et la route ; l'activation réelle
et les tests HTTP dans Back doivent suivre la disponibilité de cette version
dans le package Composer du projet. Pas de changement automatique du
runtime installé avant mise à jour du package.
