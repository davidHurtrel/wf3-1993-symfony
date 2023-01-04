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
git add .
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

## RÉCUPÉRER UN PROJET EXISTANT

- télécharger le zip faire un pull

## SYMFONY SERVER

- démarrer le serveur Symfony :
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
