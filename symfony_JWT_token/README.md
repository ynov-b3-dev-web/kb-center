# Authentification avec JWT

## Prérequis

Pour cet exemple nous serons sur symfony version 5.4, pour l'installer faire la commande suivante :


```bash
symfony new auth --version=5.4
```

Nous aurons également besoin d'une base de données, pour cela ajouter la ligne suivante au .env

```php
DATABASE_URL="mysql://root:password@127.0.0.1:3306/auth?serverVersion=5.7"
```

`root` étant le nom d'utilisateur 
`password` le mot de passe 
`auth` le nom de la table 


Ensuite, installer les packages suivants :

```bash
composer require symfony/orm-pack
```
```bash
composer require --dev symfony/maker-bundle
```


Pour créer la base de données il faut lancer la commande suivante :

```bash
php bin/console doctrine:database:create
```

## Création d'une Entity User

Faire les commandes suivantes pour avoir le bundle security

```bash
composer require symfony/security-bundle
```

Maintenant que les bundles sont installées faire la commande `php bin/console make:user` pour créer une l'entity User

- Dans un premier temps on vous demandera que nom vous souhaitez donner à votre classe : par défaut User

- Ensuite, on vous demande si vous souhaitez le stocker en base : Par défaut oui

- Vous devez choisir le nom de l'entité qui sera unique : Par default email

- Et enfin vous dites si vous souhaitez hasher les mots de passe : Par defaut oui

Une fois toutes ces informations renseignées, vous avez votre entité User, il faut maintenant ajouter User à la base donnée avec ces deux commandes :

```bash
php bin/console make:migration
```


```bash
php bin/console doctrine:migrations:migrate
```

Une fois la table User ajouter à la base nous pouvons créer un utilisateur

Pour le rôle rentrer seulement `[]` pour avoir "ROLE_USER"

Et pour le mot de passe lancer la commande suivante pour le crypter

```bash
bin/console security:hash-password '1234'
```

"1234" étant le mot de passe 

Il nous vous reste plus qu'à copier le mot de passe haché et à l'insérer en base

## Ajout JWT


Nous allons utiliser LexikJWTAuthenticationBundle pour le JWT	

Lien de la doc : (https://github.com/lexik/LexikJWTAuthenticationBundle/blob/2.x/Resources/doc/index.rst#getting-started)

Pour l'installer lancer la commande suivante:

```bash
composer require "lexik/jwt-authentication-bundle"
```

Nous allons également avoir besoin de générer une clé ssh privé et public qui va permettre d'avoir un JWT unique

Attention si vous êtes sous Windows pensez à installer openSSL

```bash
php bin/console lexik:jwt:generate-keypair
```

Maintenant ajouter les lignes suivantes dans config/packages/security.yaml avant main et dev dans firewall :


```php
        login:
            pattern: ^/api/login
            stateless: true
            json_login:
                check_path: /api/login_check
                success_handler: lexik_jwt_authentication.handler.authentication_success
                failure_handler: lexik_jwt_authentication.handler.authentication_failure

        api:
            pattern:   ^/api
            stateless: true
            jwt: ~
```



Ajouter ces lignes dans config/routes.yaml : 


```php
api_login_check:
    path: /api/login_check
```

Maintenant que tout est configuré allons sur insomnia ou postman

Dans le header ajouter 


```bash
Content-Type application/json
```

Faire une requête post avec l'URL suivante :

http://localhost:8000/api/login_check

Ajouter le json suivant :
```php
{
    "username": "toto@toto.com",
    "password": "1234"
}
```

et lancer la requête

Bravo, vous êtes authentifié et avez reçu votre token


Si vous souhaitez changer la durée du token il faut aller dans config/packages/lexik_jwt_authentication.yaml :
Ajouter cette ligne

 
```php
    token_ttl: 3600
```

3600 est en seconde ça correspond à une 1h, par défaut le token dure 1h
