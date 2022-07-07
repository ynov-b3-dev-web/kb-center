# Présentation GraphQL

## Qu'est-ce que GraphQL ?

GraphQL est un language de requète pour les api. GraphQL est concu pour envoyer uniquements les données qui ont été demandé par le client. Cela permet d'optimiser les performances et la flexibilité d'une api.

## Les différences avec une rest api

En rest api nous avons des méthodes http comme get, post, put, patch, delete... En graphql, il y a uniquement les queries et les mutations.

L'équivalent d'un enpoint rest api est graphQL est un "resolver".

Les queries sont comme les get en rest api. C'est-à-dire qu'ils ne vont pas modifier des données mais uniquement en récupérer. Les mutations sont comme les post, put, patch et delete en rest api. Leur objectif est de modifier des données. Attention, les mutations peuvent aussi renvoyer des données.

La question que l'on pourrait se poser est : pourquoi avoir des queries ET des mutations ?

En graphQL typer soit en query, soit en mutation permet de différencier les modifications (mutations), des simples récupérations de données (query).

## Les resolvers

En graphQL, un endpoint s'appel un resolver. Par exemple :

query getAccount {
  account {
    lastName
    firstName
    username
    email
    phone  
  }
}

Dans cet exemple, on appel le resolver account. On déclare vouloir récupérer uniquement lastName, firstName, username, email et phone.

On peut aussi faire plusieurs requètes en une. Par exemple :

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

Dans cette requète, on appel deux resolvers en meme temps. Faire plusieurs requètes en une est très performant pour deux raisons :

- cela crée une seule requète http et donc réduit la taille des paquets envoyés.
- les queries sont éxécutées en parallele

L'ensemble des requètes d'un back forme ce que l'on appel un schéma.

GraphQL est un must pour utiliser les micro services car il permet d'avoir un schéma unifié à appeler qui est lui-meme composé de plusieurs services pour chaque micro-service.

Airbnb utilise ce système : https://qeunit.com/blog/airbnbs-microservices-architecture-journey-to-quality-engineering/
