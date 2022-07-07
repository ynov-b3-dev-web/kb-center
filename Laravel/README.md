# Présentation de laravel

## Déifinition de laravel

Laravel est un framework Backend orienté web, utilisant un langage script. Basés sur le modèle MVC, laravel fournir des outils ainsi que des moduls permettant de développer rapidement et facilement.
On peut utilisé laravel soit pour faire une api soit pour faire un fullstack c'est à dire à la fois en backend et frontend.
Les principales différence avec symphoni c'est que laravel permet pas les migrations automatique,symphony ce base sur les composant qu'il réutilise alors que laravel ce base sur le MVC.

Pour pouvoir utiliser laravel il avoir sur son environnement un Php et composer installer.

## Fonctionnement de laravel

Commande pour créer un projet laravel par exempl test
```php
composer create-project --prefer-dist laravel/laravel test
```

Lancer tinker
```php
php artisan tinker
```

Lancer le serveur laravel
```php
php artisan serve
```

Installer tinker permet d'exécuter les requêtes Sql en ligne de commande.
```php
composer require laravel/tinker
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
Pour créer un modele et un Productcontrolleur
```php
php artisan make:model Product
php artisan make:controller ProductController --resource
```      
Sur un model on déclarer les atribut de la carte pour pouvoir utilisé dans l'application.Puisque ca nous permet de travailler en objet.```php
 protected $fillable = [
        'name',
        'price',
       
    ];
```  
## Quelque requête et affichage

Dans une méthode du controlleur nous pouvons transmettre des données à la vue. Ci dessous nous envoyez à la vue welcome la données Products qui à tous les produit. Dans l'exemple ci dessous on envoie la données Products à la vue welcome
```Ici on envoie la données Products à la vue welcome
$Products = Product::All();
return View('welcome', ['produits' => $Products]);
```
Ensuite il faut écrire une route dans le fichier web.php
```php
Route::get('/', 'ProductGController@Products');
```
```
@foreach ($Products as $product)
<p>{{ $product->name }}</p>
 @endforeach
```

Il existe la méthode save qui simplifie la creation et la modification de données. En déclarant un objet correspondant à la données qu'on travail on peut utilisé la méthode save permettant de sauvegarder la données
```Ici on envoie la données Products à la vue welcome
$Product = new Product();
        $Product->name=$request->name;
        $Product->price=$request->price;
        $Product->save();
```

On peut envoyez des informations via le routing, ci dessous on envoie une lis
```
Route::get('/', function() {
   $titre = 'Laravel';
   return view('welcome', ['articles' => $titre]);
   
});
```
Pour afficher la données correspondant , une fois passez dans la route on à juste à l'appeler .
```

 <h2>{{ $Titre }}</h2>
```

## Quelque outils fournir par laravel:
Laravel nous donne plussieurs module qui nous permet de développer facilement certaine fonctionnalité .
T-elle que:
- Mailable pour l'envoie de mail
- authentification
- Plussieurs choix possible de base de données (Mysql, sqlite etc ...), juste à adapter la configuration
- Une configuration pour pouvoir l'utiliser à memcached ainsi que redis

## Quelque liens pour laravel:
-https://laravel.com/
-https://laravel.sillo.org/laravel-9/
-https://themewp.inform.click/fr/comment-utiliser-laravel-tinker/


