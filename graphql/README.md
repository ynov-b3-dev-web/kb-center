# Présentation GraphQL

## Qu'est-ce que GraphQL ?

GraphQL est un language de requête pour les API. GraphQL est conçu pour envoyer uniquement les données qui ont été demandées par le client. Cela permet d'optimiser les performances et la flexibilité d'une API.

## Les différences avec une API Rest

Avec une API Rest, nous avons des méthodes HTTP comme GET, POST, PUT, PATCH, DELETE...avec GraphQL, il y a uniquement les queries et les mutations.

L'équivalent d'un enpoint Rest API en GraphQL est un "resolver".

Les queries sont comme les requêtes GET dans une API Rest, c'est-à-dire qu'ils ne vont pas modifier des données mais uniquement en récupérer.

Les mutations sont comme les POST, PUT, PATCH et DELETE en Rest API. Leur objectif est de modifier des données. Attention, les mutations peuvent aussi renvoyer des données.

La question que l'on pourrait se poser est : pourquoi avoir des queries ET des mutations ?

En GraphQL typer soit en query, soit en mutation permet de différencier les modifications (mutations), des simples récupérations de données (query).

## Les resolvers

En GraphQL, un endpoint s'appelle un resolver. Par exemple :

```txt
query getAccount {
  account {
    lastName
    firstName
    username
    email
    phone  
  }
}
```

Dans cet exemple, on appelle le resolver account. On déclare vouloir récupérer uniquement lastName, firstName, username, email et phone.

On peut aussi faire plusieurs requètes en une. Par exemple :

```txt
query getAll {
  account {
    lastName
    firstName
    username
    email
    phone  
  }
  products {
    name
    price
  }
}
```

Dans cette requète, on appelle deux resolvers en même temps. Faire plusieurs requètes en une est très performant pour deux raisons :

- cela crée une seule requète HTTP et donc réduit la taille des paquets envoyés
- les queries sont exécutées en parallèle

L'ensemble des requêtes d'un back forme ce que l'on appelle un schéma.

GraphQL est un must pour utiliser les micro services car il permet d'avoir un schéma unifié à appeler qui est lui-même composé de plusieurs services pour chaque micro-service.

Airbnb utilise ce système : https://qeunit.com/blog/airbnbs-microservices-architecture-journey-to-quality-engineering/
