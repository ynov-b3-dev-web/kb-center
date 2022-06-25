# Rappel objet : les interfaces

Le rappel effectué porte sur une classe du composant `Security` de Symfony : la classe `User`.

## Contexte

Avec le framework Symfony, quand on souhaite créer diverses choses, on peut utiliser la console, et plus particulièrement un outil de génération de code appelé le `Maker`.

Par exemple, si on souhaite créer une entité pour notre modèle, on peut utiliser la commande suivante :

```bash
php bin/console make:entity
```

Par la suite, l'invite de commande nous guide dans la création de l'entité, afin de générer et déposer le fichier final dans le dossier `src/Entity` (et son Repository associé dans `src/Repository`).

Le `Maker` propose une autre commande, permettant quant à elle de créer une entité **utilisateur**, alors capable d'être intégrée et utilisée par le composant `Security` de Symfony, pour réaliser de l'authentification, des autorisations, etc...

```bash
php bin/console make:user
```

## Pourquoi `make:entity` et `make:user` ?

> Qu'est-ce qui change entre ces deux commandes ? Pouquoi ne pas utiliser le `Maker` avec `make:entity` ?

Comme on le disait juste avant, la commande `make:user` va créer une entité **compatible** avec le composant `Security`. Concrètement, quand on crée une entité habituellement avec `make:entity`, le maker nous sort un fichier de ce type :

```php
<?php
namespace App\Entity;

// use...

#[ApiResource]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
  //...
}
```

Mais on si utilise `make:user`, le maker nous génère ceci :

```php
<?php

namespace App\Entity;

// use...
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ApiResource]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
  //...
}
```

Notre entité implémente deux interfaces : `UserInterface` et `PasswordAuthenticatedUserInterface`. Elles appartiennent toutes deux au composant `Security` de Symfony (voir les `use`).

## Pourquoi implémenter des interfaces ?

La première chose à retenir, c'est qu'une interface est un **contrat d'implémentation** pour toute classe prétendant l'implémenter (avec le mot-clé `implements`).

Une interface définit une ou plusieurs **signature(s) de fonction(s)**, indiquant que toute classe souhaitant l'implémenter doit alors fournir une implémentation concrète de ces fonctions.

> Concrètement, cela signifie que si je dispose d'une classe `User` qui indique `implements UserInterface`, alors je retrouverai dans la classe `User` les méthodes définies dans `UserInterface`. Et ceci vaut pour n'importe quelle classe et n'importe quelle interface

Du point de vue du composant `Security`, on ne fait que fournir des fonctionnalités destinées à gérer de l'authentification et de l'autorisation.

Le composant `Security` est un package, c'est-à-dire que dans n'importe quel projet l'utilisant, il ne se trouve pas dans le code de l'application, mais au sein du dossier `vendor`.

Par ailleurs, n'importe quelle application pourra définir un `User` de la façon dont elle le souhaite. Il pourrait avoir un email, un nom, un prénom, un UUID, etc...et ça, le composant `Security` ne peut pas le prévoir à l'avance.

Ainsi, il va s'appuyer sur une abstraction, donc `UserInterface`, plutôt qu'une classe concrète. Ceci lui permettra de manipuler n'importe quelle classe implémentant cette interface, donc depuis n'importe quelle application. Ceci permet d'être plus flexible lors des développements.

Dans notre application, le composant `Security` manipulera bien un `User`, mais de son point de vue, il le considèrera comme un `UserInterface` : il saura donc qu'il pourra appeler n'importe quelle méthode définie dans `UserInterface`.

## Exemple : la classe `AbstractToken`

Le jeton de sécurité (ou security token) est utilisé par le composant `Security` pour diverses opérations. Par exemple, lorsque l'authentification est gérée avec les sessions, il est utilisé pour vérifier que les informations d'un utilisateur sont toujours les mêmes ([documentation](https://symfony.com/doc/current/security.html#understanding-how-users-are-refreshed-from-the-session)).

Si on regarde la classe abstraite `AbstractToken`, on remarque qu'elle possède un attribut `user` de type `?UserInterface` (donc soit `UserInterface`, soit `null`) :

```php
<?php

//...

abstract class AbstractToken implements TokenInterface, \Serializable
{
  private ?UserInterface $user = null;
  private array $roleNames = [];
  private array $attributes = [];

  //...
}
```

Ainsi, un peu plus loin, dans la méthode `getUserIdentifier`, en [ligne 51](https://github.com/symfony/security-core/blob/6.1/Authentication/Token/AbstractToken.php#L51), on voit que le code écrit fait appel à la méthode `getUserIdentifier` sur l'attribut `$user`.

Dans l'interface, la signature de cette méthode [est bien définie](https://github.com/symfony/security-core/blob/6.1/User/UserInterface.php#L60). Un token manipulant un `UserInterface` peut donc appeler cette méthode en tout tranquillité, sans se soucier de son type concret ni de ses autres attributs, méthodes, etc...

## Résumé

Le parallèle avec les signatures de méthodes définies dans des interfaces pourrait être les **méthodes abstraites** dans des classes abstraites, qui forcent les enfants d'une classe abstraite à fournir une implémentation de chaque méthode abstraite déclarée.

Le fait de s'appuyer sur des abstractions plutôt que des classes concrètes permet d'être plus flexible, en définissant un comportement général au travers d'un **contrat d'implémentation**.

Cette technique fait partie des principes [SOLID](https://en.wikipedia.org/wiki/SOLID), et plus spécifiquement la lettre D de l'acronyme, [Dependency Inversion](https://en.wikipedia.org/wiki/Dependency_inversion_principle), ou Inversion de dépendance.
