# SymSvel Core

> [!IMPORTANT]
> **Vous souhaitez utiliser SymSvel ? Rendez-vous sur [SymSvel CLI](https://github.com/Symsvel-Framework/symsvel-cli).** Ce dépôt est un **composant du framework**, pas un point d'installation autonome. Création de projets, installation des modules et mises à jour passent par la CLI. Les éventuelles commandes Composer, npm ou Symfony décrites ci-dessous concernent le travail des mainteneurs, sauf indication explicite contraire.

> [!WARNING]
> **SymSvel est en cours de développement.** Les fonctionnalités et procédures peuvent évoluer ou présenter des anomalies. **Utilisation à vos risques et périls.**

Bundle Symfony de runtime technique : package Composer `symsvel-framework/core`.

Le dépôt contient actuellement :

- `src/SymSvelCoreBundle.php` : bundle Symfony activable dans l'application ;
- `src/Http/ApiResponse.php` : construction de réponses API selon le contrat du framework ;
- `tests/BundleTest.php` et `tests/ApiResponseTest.php` : tests associés.

Le Core reste volontairement léger : les fonctions applicatives, données métier, pages et règles propres aux domaines appartiennent aux modules. Les opérations d'installation, de mise à jour, de migrations et de maintenance relèvent de la CLI et du Tooling, pas du runtime Core.

Voir [les responsabilités des composants](https://github.com/Symsvel-Framework/symsvel-back/blob/main/docs/architecture/composants.md) et [le contrat de réponses API](https://github.com/Symsvel-Framework/symsvel-back/blob/main/docs/api-contract.md).

Cette description porte sur le code présent dans ce dépôt ; elle ne présume pas de futures extractions du Back.

## Intégration continue GitHub-hosted (22/11/2026)

Les workflows de ce dépôt public s'exécutent sur **GitHub-hosted Ubuntu 24.04**, avec les dépendances installées dans chaque job (plus de runner Docker local). Le workflow actif est `.github/workflows/ci.yml`. Composer, lint PHP et PHPUnit restent exécutés avec PHP 8.4. Les publications GitHub Release par tag exécutent aussi leurs workflows sur GitHub-hosted.

Les runners auto-hébergés du mainteneur restent réservés à `symsvel-packages` et `symsvel-recipes` (privés). Les CI et les crash-tests locaux sont des validations distinctes.


## Liveness HTTP natif (19/11/2026)

Core fournit `SymSvel\\Core\\Controller\\HealthController` pour le
point d'entrée `GET /api/health`. Le contrat public utilise
`ApiResponse::success(['status' => 'ok'])` et `Cache-Control: no-store` :
`{"data":{"status":"ok"}}`. Aucune base, cache, transport mail, queue ou
module métier n'est interrogé. Un succès signifie **uniquement** que
le routeur Symfony a pu exécuter cette action ; il ne garantit pas la
disponibilité des autres services (readiness à traiter séparément).

Le contrôleur et son service sont propres au Core et ne créent pas de
nouveau module. Le bundle enregistre le service avec les tags Symfony natifs
`controller.service_arguments` et `routing.controller` ; le Back utilise déjà
la ressource `routing.controllers` dans `config/routes.yaml`. Cette approche
importe l'attribut `#[Route]` sans dépendance aux chemins `vendor/`, sans
fichier de routes généré et sans routeur propriétaire. Les projets doivent
installer la version de Core contenant cet enregistrement.

Les tests Core vérifient le contrat JSON, les métadonnées `#[Route]` et
les tags de la définition de service. Un test HTTP avec le Core `dev` réellement
installé dans Back et le crash-test XT doivent encore confirmer la présence
de `GET /api/health` dans le routeur et sa réponse, sans considérer ce seul
point de liveness comme une vérification de disponibilité de la base.
Pas de changement automatique du runtime installé avant mise à jour du package.

### Ajustement du contrat de test (19/11/2026)

Les métadonnées `Symfony\\Component\\Routing\\Attribute\\Route`
sont inspectées via les arguments de l'attribut PHP ; elles ne sont
pas un objet `Symfony\\Component\\Routing\\Route` et n'exposent pas
les getters de celui-ci. Le Cache-Control est validé par la présence
de `no-store` : Symfony peut également y ajouter `private`, ce qui
n'altère pas la sémantique anti-cache du point de liveness.

## Licence MIT et contributions

Ce dépôt est distribué sous [licence MIT](LICENSE). Le code peut être utilisé, modifié et redistribué, y compris dans des projets commerciaux ou propriétaires, dans les conditions de cette licence (notamment la conservation de la notice de copyright et de licence).

**Contribuer :** créer un fork, puis proposer une pull request vers `dev` lorsque cette branche existe, sinon vers la branche par défaut. Expliquer la modification et fournir les tests et la documentation concernés. Les mainteneurs conservent la maîtrise des revues, des validations (CI et crash-tests), de l'intégration et des releases officielles. Une PR ne garantit pas son acceptation.

**Versions officielles :** seules les versions diffusées par l'organisation [Symsvel-Framework](https://github.com/Symsvel-Framework) sont officielles. Les forks sont libres sous MIT, mais ne doivent pas être présentés comme officiellement approuvés par les mainteneurs. Cette distinction n'ajoute aucune restriction aux droits accordés par la licence MIT sur le code.

## Participer et soutenir le projet

SymSvel est un projet en cours de développement. Pour contribuer, proposer une amélioration ou échanger avec le mainteneur : **[xavier@xavier-tezza.fr](mailto:xavier@xavier-tezza.fr)**.

SymSvel vous est utile et vous souhaitez me remercier ? **Offrez-moi une bière ! 🍺** (lien PayPal à compléter avant l'ouverture publique).
