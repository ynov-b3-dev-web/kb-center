# Présentation de Laravel

## Défiinition de Laravel

Laravel est un framework Backend orienté web, utilisant un langage script. Basé sur le modèle MVC, Laravel fournit des outils ainsi que des modules permettant de développer rapidement et facilement.

On peut utiliser Laravel soit pour faire une API soit pour faire une application Fullstack c'est-à-dire à la fois en backend et frontend.

Les principales différence avec Symfony c'est que Laravel ne permet pas les migrations automatiques, Symfony se base sur des composants qu'il réutilise alors que Laravel se base sur le MVC.

Pour pouvoir utiliser Laravel il avoir sur son environnement PHP et Composer.

## Fonctionnement de Laravel

Commande pour créer un projet Laravel par exemple test

```php
composer create-project --prefer-dist laravel/laravel test
```

Lancer tinker

```php
php artisan tinker
```

Lancer le serveur Laravel

```php
php artisan serve
```

Installer tinker permet d'exécuter les requêtes Sql en ligne de commande.

```php
composer require Laravel/tinker
```

Pour lancer les migrations vers la base de données, pour pouvoir ainsi générer la base de données

```php
php artisan migrate
```

Pour créer un fichier migration Product

```php
php artisan make:migration create_product_table
```

Dans le fichier de migration on définit la table comme ceci

```php
public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
        });
    }
```

Pour créer un modele et un ProductController

```php
php artisan make:model Product
php artisan make:controller ProductController --resource
```

Sur un model on déclare les attributs de la carte pour pouvoir utiliser dans l'application. Puisque cela nous permet de travailler en objet.

```php
 protected $fillable = [
        'name',
        'price',
       
    ];
```

## Quelques requêtes et affichage

Dans une méthode du contrôleur nous pouvons transmettre des données à la vue.

Ci-dessous nous envoyons à la vue welcome la donnée Products qui a tous les produits.

Dans l'exemple ci-dessous on envoie la donnée `$Products` à la vue welcome :

```php
$Products = Product::All();
return View('welcome', ['produits' => $Products]);
```

Ensuite il faut écrire une route dans le fichier web.php

```php
Route::get('/', 'ProductGController@Products');
```

```html
@foreach ($Products as $product)
<p>{{ $product->name }}</p>
 @endforeach
```

Il existe la méthode save qui simplifie la création et la modification de données.

En déclarant un objet correspondant à la donnée qu'on travaille on peut utiliser la méthode save permettant de sauvegarder la donnée :

```php
$Product = new Product();
$Product->name=$request->name;
$Product->price=$request->price;
$Product->save();
```

On peut envoyer des informations via le routing :

```php
Route::get('/', function() {
   $titre = 'Laravel';
   return view('welcome', ['articles' => $titre]);
   
});
```

Pour afficher la donnée correspondante, une fois passée dans la route on à juste à l'appeler :

```html
 <h2>{{ $Titre }}</h2>
```

## Quelque outils fournis par Laravel

Laravel nous donne plusieurs modules qui nous permettent de développer facilement certaines fonctionnalités telles que :

- Mailable pour l'envoi de mail
- Authentification
- Plusieurs choix possibles de bases de données (Mysql, sqlite etc ...), juste à adapter la configuration
- Une configuration pour pouvoir l'utiliser avec memcached ainsi que redis

## Quelques liens pour Laravel

- https://Laravel.com/
- https://Laravel.sillo.org/Laravel-9/
- https://themewp.inform.click/fr/comment-utiliser-Laravel-tinker/
