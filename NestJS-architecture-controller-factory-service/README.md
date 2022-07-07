# Présentation de NestJS

NestJS est un framework backend Typescript basé sur Angular et utilisant donc NodeJS.
Il utilise Typescript afin de mieux typer le code ce qui nous permet d'être plus rigoureux dans la rédaction de celui-ci.

Très puissant, scalable et à la pointe de la technologie en matière de javascript, il s'inscrit comme une réelle solution à part entière en terme de framework backend.

## Les avantages de NestJS

NestJS est un framework complet offrant de nombreuse fonctionnalités, il permet d'accomplir les mêmes tâches qu'un Symfony ou Laravel. Le tout en restant dans un environnement Javascript / NodeJS.

Comme tous les frameworks backend JS son déploiement est relativement facile et ne nécessite pas de serveur Apache.

## les inconvénients de NestJS

NestJS possède une "architecture" qui lui est propre. En effet un projet NestJS est découpé en modules qui embarquent toutes sortes de fonctionnalités telles que les providers, les controllers, les imports et exports.

Cette architecture est à première vue assez complexe et nécessite un temps d'adaptation pour comprendre tous les tenants et les aboutissants que celle-ci induit.

## L'architecture controller - factory - service dans NestJS

Notre problématique était en fonction d'une URL donnée (Twitter ou Linkedin par exemple) d'aller chercher les données du tweet ou du post Linkedin en question afin de les mettre en forme du côté front.

Pour ce faire, plusieurs étapes :

- Le controlleur qui se charge de récupérer l'URL via une requête HTTP. Ensuite son rôle est d'appeler la factory, récupérer l'objet généré, et renvoyer les données requêtées au front afin qu'il les mette en forme.

```typescript
@Controller()
export class ProcessController {
  constructor(private appFactory : AppFactory) {}
    @Post('/search')
    process(@Body() { url } : { url: string }) {
      const handler = this.appFactory.createHandler(url);
      const data = handler.formatData(url);
      return data;
    }
}
```

- La factory est donc appelée. Son rôle va être de "rediriger" le process vers le bon service en fonction d'une certaine condition : ici la factory se charge donc d'appeler le bon service en regardant si l'URL possède telle ou telle chaine de caractère.

```javascript
@Injectable()
export class AppFactory {
    constructor(private configService : ConfigService, private httpService : HttpService) { }

    createHandler(url: string): AbstractProcess {
        if (url.includes("twitter")) {
            return new TwitterProcess(this.httpService, this.configService)
        }
        if (url.includes("linkedin")) {
            return new LinkedinProcess();
        }
    }
}
```

### Problématique

Chaque service possède ses propres dépendances pour fonctionner. Ce qui fait qu'à chaque implémentation d'un nouveau service ses nouvelles dépendances devaient être déclarées dans le constructeur de la factory.

Au final, cette méthode n'est pas du tout optimisée car pour chaque nouveau service il faut l'implémenter, l'instancier dans la factory, ajouter ses dépendances dans le constructeur, etc...

Très vite nous nous retrouvons avec un constructeur à rallonge qui initialise chaque dépendance inutilement.

De plus chaque modification des dépendances d'un service nous oblige à intervenir logiquement dans celui-ci mais en plus de cela il nous oblige également à intervenir dans la factory. Ce qui rajoute une charge de travail supplémentaire inutile.

### Solution

Pour contourner ce problème nous avons eu recours à l'IOC : l'inversion de contrôle.

En effet le but ici est d'inverser le contrôle : ce n'est plus nous qui sommes chargé à la main de déclarer et d'instancier les classes avec leurs dépendances mais ici c'est le framework qui va s'en occuper automatiquement.

Avec NestJS nous utilisons la classe ModuleRef qui importe la méthode get qui va automatiquement aller chercher les dépendances de la classe fournie en paramètre, va "l'instancier" automatiquement, mais aussi résoudre et injecter ses propres dépendances.

```javascript
@Injectable()
export class AppFactory {
    constructor(private moduleRef : ModuleRef) { }

    createHandler(url: string) {
        if (url.includes("twitter")) {
            return this.moduleRef.get(TwitterProcess);
        }
        if (url.includes("linkedin")) {
            return this.moduleRef.get(LinkedinProcess);
        }
    }
}
```

Ainsi, le constructeur de la factory ne dispose plus que de l'injection de la classe ModuleRef et la suite est gérée automatiquement.

- Le service, il se charge de la dernière étape qui est donc le fonctionnement de la récupération des données. Différente pour chaque service, nous allons prendre l'exemple de twitter :

```javascript
@Injectable()
export class TwitterProcess extends AbstractProcess {
  constructor(private httpService: HttpService, private configService: ConfigService) {
    super();
  }

  extractId(url: string) {
    const result = new RegExp(/\w+$/).exec(url)
    return result[0];
  }

  request(url: string) {
    const tokenTwitter = this.configService.get('token.bearerTwitter');
    return this.httpService.get('https://api.twitter.com/2/tweets/' + this.extractId(url) + '?expansions=author_id,attachments.media_keys&tweet.fields=created_at,public_metrics&user.fields=name,profile_image_url&media.fields=url,type,preview_image_url', {
      headers: {
        authorization: tokenTwitter
      }
    }).pipe(
      map((axiosResponse: AxiosResponse) => {
        return axiosResponse.data
      })
    );
  }

  async formatData(url: string) {
    const data = await lastValueFrom(this.request(url));

    // Traitement et transformation des data récupérées...

    return finalDataJson;
  }
}
```

Ici, de nombreuses fonctionnalités sont présentes : premièrement on vient requêter l'API de Twitter pour récupérer les informations du tweet que l'utilisateur a entrées sur l'interface. Pour ce faire, nous retirons l'id du tweet grâce à une regex et ensuite nous l'intégrons simplement dans l'URL de la requête.

Ensuite, via la requête et un observable nous récuperer les données puis nous transformons l'observable en Promise via la fonction lastValueFrom(). Ceci nous permet d'appliquer un traitement asynchrone `async/await`.

Finalement, nous les mettons en forme au format JSON pour qu'elles soient le plus simple possible à exploiter une fois renvoyées vers le front.

Ces données sont donc retournées jusqu'au controlleur qui se charge d'envoyer la réponse au front qui les met en forme.
