# SymSvel Core

Bundle Symfony de runtime technique : package Composer `symsvel-framework/core`.

Le dépôt contient actuellement :

- `src/SymSvelCoreBundle.php` : bundle Symfony activable dans l'application ;
- `src/Http/ApiResponse.php` : construction de réponses API selon le contrat du framework ;
- `tests/BundleTest.php` et `tests/ApiResponseTest.php` : tests associés.

Le Core reste volontairement léger : les fonctions applicatives, données métier, pages et règles propres aux domaines appartiennent aux modules. Les opérations d'installation, de mise à jour, de migrations et de maintenance relèvent de la CLI et du Tooling, pas du runtime Core.

Voir [les responsabilités des composants](https://github.com/Symsvel-Framework/symsvel-back/blob/main/docs/architecture/composants.md) et [le contrat de réponses API](https://github.com/Symsvel-Framework/symsvel-back/blob/main/docs/api-contract.md).

Cette description porte sur le code présent dans ce dépôt ; elle ne présume pas de futures extractions du Back.
