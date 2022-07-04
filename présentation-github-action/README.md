
# Github Action

Github action est un outil mis à disposition par Github pour pouvoir créer des Workflows de CI/CD pour déployer, tester, build...ses applications.

![alt text](https://miro.medium.com/max/2617/1*8mUtip6z_oydfLi4P86KUw.png)

## Workflow

Un Workflow est la modélisation d'un processus à exécuter. À l'intérieur, on retrouve toutes les étapes essentielles au fonctionnement d'un Pipeline de CI/CD.

Sur github action les Workflows sont créés dans un fichier .yml, présent dans un dossier nommé `.github/workflows/`.

## Runner

Un runner est une machine virtuelle qui a une application de running dédié installée, elle permet d'exécuter le workflow.

## Event

Un event une action réalisée sur le dépôt Git distant qui déclenche le Pipeline de CI/CD.

Dans le fichier *.yml, il s'identifie comme suit :

```yml
name: Deploy to Firebase Hosting on merge
'on':
  push:
    branches:
      - main
  pull_request:
    branches: 
      -  main 
```

Dans cet exemple, on retrouve 2 types de triggers d'event :

- Le premier est sur `push` sur la branche "main"
- Le deuxième trigger est sur un event `pull_request` fait sur la branche "main"

## Job

Lorsque l'event est déclenché, les jobs sont donc exécutés, autrement dit les tâches demandées sont exécutées par un runner.

Un job est un ensemble de "Steps", autrement dit d'étapes qui s'exécutent les unes à la suite des autres.

En raison d’une nature séquentielle, une étape dépend de la précédente. Si une étape précédente modifie un environnement, les étapes ultérieures sont affectées par les modifications.

Si une étape échoue ou exécute une commande de sortie avec un signal d’échec, le flux de travail est annulé.

Exemple :

```yml
jobs:
  build_and_deploy:
    runs-on: ubuntu-latest
```

ici le nom de mon pipeline est "build_and_deploy", et le choix du runner est la dernière version d'Ubuntu.

> Il est possible de transformer son PC en runner, en suivant la [documentation dédiée](https://docs.github.com/en/actions/hosting-your-own-runners/about-self-hosted-runners)

## Steps

Voici un exemple de déclaration de steps dans un pipeline :

```yml
  steps:
    - uses: actions/checkout@v2
    - uses: actions/setup-java@v1
      with:
        java-version: '12.x'
    - uses: subosito/flutter-action@v1
    - name: 'Run flutter pub get'
      run: flutter pub get
    - name: 'Build Web App'
      run: flutter build web
    - uses: FirebaseExtended/action-hosting-deploy@v0
      with:
            repoToken: '${{ secrets.GITHUB_TOKEN }}'
            firebaseServiceAccount: '${{ secrets.FIREBASE_SERVICE_ACCOUNT_BIBLIO_55CA4 }}'
            channelId: live
            projectId: biblio-55ca4
```

ici chaque `step` correspond à une action spécifique :

- les `uses` correspondent à des Actions disponibles dans le MarketPlace
- les `run` sont des commandes qui seront executées sur le runner

![alt text](https://res.cloudinary.com/practicaldev/image/fetch/s--lckI24Rr--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_880/https://cdn.hashnode.com/res/hashnode/image/upload/v1649381586908/ypdUHzjUr.png)

## Premier Pipeline

Voici le modèle de notre premier pipeline :

![alt text](https://res.cloudinary.com/practicaldev/image/fetch/s--tfs5X4w---/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_880/https://cdn.hashnode.com/res/hashnode/image/upload/v1649373965048/k3ExcTcW5.png)

Voici comment il se présente dans le fichier `hello.yml` dans un dossier `.github/workflows/` :

```yml
name: hello-world
on: push
jobs:
  my-job:
    runs-on: ubuntu-latest
    steps:
      - name: my-step
        run: echo "Hello World!"
```

Lors du push du projet, ce pipeline sera déclenché.

## Action MarketPlace

Certaines actions répétitives possèdent leur propre pipeline dédié retrouvable [dans le MarketPlace](https://github.com/marketplace?type=actions).

## Auteur

Stéphane Duboze
