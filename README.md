# SYMFONY

## NOUVEAU PROJET

- ouvrir le terminal
- se rendre dans le dossier où l'on va créer le projet (ex.: MAMP/htdocs) :
```
cd chemin_vers_le_dossier
```
- créer le projet avec Symfony CLI (pas de besoin de créer le dossier du projet) :
```
symfony new --webapp nom_du_projet --version=6.2
```
- créer le projet avec Composer (pas de besoin de créer le dossier du projet) :
```
composer create-project symfont/website-skeleton nom_du_projet ^6.2.*
```

## GIT

- créer un dépôt GitHub
- avec un terminal, se rendre dans le dossier du projet :
```
cd chemin_vers_le_dossier
```
- initialiser le dépôt local :
```
git init
```
- lier le dépôt local au dépôt distant :
```
git remotre add origin https://github.com/davidHurtrel/nom_du_depot_distant.git
```
- ajouter les fichiers
```
git add . (ou *)
```
- donner un nom au commit :
```
git commit -m "message_du_commit"
```
- envoyer les modifications :
```
git push origin main (ou master pour les plus anciennes versions de Git)
```
- voir la liste de commits :
```
git log
```

## RÉCUPÉRER UN PROJET

- télécharger le zip ou faire un pull
- recréer le fichier .env.local à la racine du projet (avec ses propres informations), les informations importantes sont APP_ENV, APP_SECRET et MAILER_DSN (éventuellement MAILER_URL)
- mettre à jour le projet (installer les dépendances, générer le cache, ...) :
```
composer install
```
- créer la base de données (si cela n'est pas déjà fait) :
```
symfony console doctrine:database:create
```
- mettre à jour la base de données (créer, modifier, supprimer les tables) :
```
symfony console doctrine:migrations:migrate
```

## SYMFONY SERVER

- démarrer le serveur Symfony (Ctrl + C pour l'arrêter) :
```
symfony serve
```
- démarrer le serveur Symfony en arrière-plan :
```
symfony server:start -d
```
- arrêter le serveur en arrière-plan :
```
symfony server:stop
```
- installer le certificat SSL/TLS local :
```
symfony server:ca:install
```

## APACHE-PACK

- suite d'outils pour Apache (barre de débug, routing, .htaccess)
- dans le terminal :
```
composer require symfony/apache-pack
```

## CONTROLLER

- créer un controller (et le template associé) :
```
symfony console make:controller nom_du_controller
```

## VARIABLES GLOBALES

- variable utilisable dans tout fichier Twig
- dans le fichier config/packages/twig.yaml :
```YAML
twig:
    ...
    globals:
        nom_de_la_variable: 'valeur_de_la_variable'
```
- utilisation dans un fichier Twig :
```
{{ nom_de_la_variable }}
```

## BASE DE DONNÉES

- env.local :
```
DATABASE_URL="mysql://db_user:db_pass@db_host/db_name?serverVersion=5.7&charset=utf8"
```
- créer la base de données :
```
symfony console doctrine:database:create
```
- supprimer la base de données :
```
symfony console doctrine:database:drop --force
```
- créer une entité (table) ou ajouter des champs à une entité :
```
symfony console make:entity nom_de_l_entite
```
- créer l'entité User :
```
symfony console make:user
```
- migration :
```
symfony console make:migration
symfony console doctrine:migrations:migrate
```
- exécuter une requête sql :
```
symfony console doctrine:query:sql "la_requete_a_executer"
```

## FORMULAIRE

- créer un formulaire :
```
symfony console make:form nom_de_l_entite (puis préciser le nom de l'entité associée)
```
- les formulaires sont générés dans le dossier src/Form
- mise en forme des formulaires avec un thème (config/packages/twig.yaml) :
```YAML
twig:
    ...
    form_themes: ['bootstrap_5_layout.html.twig']
```
- bouton de soumission d'un formulaire (depuis le Form) :
```PHP
->add('send', SubmitType::class)
```

## MESSAGES FLASH

- dans un controller (avant la redirection) :
```PHP
$this->addFlash('le_label', 'le_message_a_afficher');
```
- dans un template (à l'endroit où l'on veut afficher le message) :
```HTML
{% for label, messages in app.flashes %}
    {% for message in messages %}
        <div class="flash-{{ label }}">
            {{ message }}
        </div>
    {% endfor %}
{% endfor %}
```

## PAGES D'ERREUR

- codes :
    - 1xx : information
    - 2xx : succès
        - 200 : OK
    - 3xx : redirection
    - 4xx : client web
        - 401 : accès refusé
        - 403 : accès interdit
        - 404 : non trouvé
    - 5xx : serveur
        - 500 : erreur interne
        - 503 : service indisponible
- si nécessaire :
```
composer require symfony/twig-pack
```
- créer l'arborescence templates/bundles/TwigBundle/Exception/
- y créer les fichiers avec l'écriture errorXXX.html.twig (où XXX est le numéro de l'erreur)
error.html.twig pour toutes les autres erreurs
- les pages d'erreur ne peuvent être visualisées qu'en environnement de production (penser à vider le cache Symfony après chaque modification)

## FIXTURES

- installer le bundle :
```
composer require --dev orm-fixtures (ou composer require --dev doctrine/doctrine-fixtures-bundle)
```
- compléter le fichier src/DataFixtures/AppFixtures.php
- persist() et flush()
- envoyer en base de données (en écrasant) :
```
symfony console doctrine:fixtures:load
```
- envoyer en base de données (en ajoutant à la suite) :
```
symfony console doctrine:fixtures:load --append
```
- bundle pour générer de fausses données :
```
composer require fakerphp/faker
```

## EMAIL

- installer le mailer (si nécessaire) :
```
composer require symfony/mailer
```
- installer le package tiers (si nécessaire pour son adresse mail) :
```
composer require symfony/google-mailer
```
- dans le paramètres de compte Google => Sécurité => Connexion à Google : activer la validation en deux étapes (pour pouvoir accéder aux Mots de passe des applications)
- créer un mot de passe d'application
- .env.local :
```
MAILER_DSN=gmail://USERNAME:PASSWORD@default
```
- pour que les messages (emails) s'envoient directement (synchrone), config/packages/messenger.yaml :
```YAML
framework:
    messenger:
        ...
        transports:
            ...
            sync: 'sync://' # décommenter pour autoriser l'envoi de messages de manière synchrone
        routing:
            Symfony\Component\Mailer\Messenger\SendEmailMessage: sync #envoit les emails de manière synchrone
```
- config/packages/web_profiler.yaml :
```YAML
when@dev:
    web_profiler:
        ...
        intercept_redirects: true # intercepte les redirection
```
- config/packages/mailer.yaml :
```YAML
framework:
    mailer:
        dsn: 'null://null' # désactive l'envoi de mails
        envelope:
            recipients: ['david.hurtrel@gmail.com'] # envoie tous les mails à cette adresse
```

## LOGIN

- créer l'authentification :
```
symfony console make:auth
```
- 1
- LoginFormAuthenticator
- SecurityController
- yes
- pour se déconnecter :
```HTML
<a href="{{ path('app_logout') }}"></a>
```

## REGISTER

- créer l'entité User :
```
symfony console make:user
```
- ajouter des champs à l'entité User :
```
symfony console make:entity User
```
- migration
- créer le formualire d'inscription :
```
symfony console make:registration-form
```
- répondre aux questions


### Si on choisit d'activer la vérification des adresses mail
- installer le bundle de vérification d'email (si on choisit d'activer la vérification des adresses) :
```
composer require symfonycasts/verify-email-bundle
```
- modifier la dernière redirection après validation de l'adresse mail (RegistrationController::verifyUserEmail())
- vérifier le formulaire, le controller et les templates
- migration pour générer la propriété User->isVerified en base de données

- installer le bundle de validation de mot de passe :
```
composer require rollerworks/password-strength-bundle
```

## SÉCURITÉ - DROITS - ACCÈS - HIÉRARCHIE

- dans confid/packages/security.yaml :
```YAML
access_control:
    - { path: ^/admin, roles: ROLE_ADMIN }
    ...
role_hierarchy:
    ROLE_ADMIN: ROLE_USER
    ROLE_SUPER_ADMIN: ROLE_ADMIN
```
- afficher du code selon un rôle :
```HTML
{% if is_granted('LE_ROLE') %}
    le_code_ici
{% endif %}
```
- vérifier les failles de sécurité / vulnérabilités des dépendances :
```
symfony security:check
```

## SERVICES

- services = objets qui font une tâche, des outils (réutilisables)
- créer le dossier src/Service (s'il n'existe pas déjà)
- y créer le fichier CartService.php

## COMMANDES UTILES

- vider le cache (Symfony) :
```
symfony console cache:clear
```
- connaître sa version de Symfony :
```
symfony console --version
```
- mettre à jour son projet / ses dépendances :
```
composer update
```
