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
