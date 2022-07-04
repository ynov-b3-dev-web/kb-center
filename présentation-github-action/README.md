
# Github action

Github action est un outil mis à disposition par Github pour pouvoir crée des Workflow de CI/CD pour .

# Workflow

Un Workflow est la modélisation d'un processus à exécuter . À l'intérieur, on retrouve toutes les étapes essentielles au fonctionnement d'un Pipeline de CI/CD

![alt text](https://miro.medium.com/max/2617/1*8mUtip6z_oydfLi4P86KUw.png)

Sur github action les Workflow sont crée dans un fichiers .yml , présent dans un dossier nommée .github/workflows/

# Runner

Un runner est une machine virtuelle qui à une application de running dédié installer, elle permet d'exécuter le workflows .

# Event

Un event une action réalisée sur le répertoire distant qui déclenche le Pipeline de CICD ,
Dans le fichiers *.yml
Il s'identifie comme suit : 

```
name: Deploy to Firebase Hosting on merge
'on':
  push:
    branches:
      - main
  pull_request:
    branches: 
      -  main 
```
Dans cet exemple, on retrouve 2 type trigger d'event :
Le premier est sur "Push" sur la branches "main"
Le deuxième trigger est sur un pull_request fait sur la branches "main"

# Job

Lorsque l'event est déclenché les Job donc, autrement dit les tâches demandées sont exécuter par un runner .
Un job est un ensemble de "Steps" , autrement dit d'étapes qui s'exécute les unes à la suite des autres.
En raison d’une nature séquentielle, une étape dépend de la précédente. Si une étape précédente modifie un environnement, les étapes ultérieures sont affectées par les modifications.
Si une étape échoue ou exécute une commande de sortie avec un signal d’échec, le flux de travail est annulé.

exemple : 
```
jobs:
  build_and_deploy:
    runs-on: ubuntu-latest

```
ici le nom de mon pipeline est "build_and_deploy" , et le choix du runner est la dernier version d'ubuntu .
Il est possible de transformer sont PC en runner  : https://docs.github.com/en/actions/hosting-your-own-runners/about-self-hosted-runners

## Steps

Voici un exemple d'éxecution de  Steps dans un pipeline 

```
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
ici chaque steps corrspond à une action spécifique :
les uses corresponde à des Action disponible dans le MarketPlace

les run sont des commandes qui seront executer 

![alt text](https://res.cloudinary.com/practicaldev/image/fetch/s--lckI24Rr--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_880/https://cdn.hashnode.com/res/hashnode/image/upload/v1649381586908/ypdUHzjUr.png)


# premier Pipeline 
Voici le model de notre premier pipeline 

![alt text](https://res.cloudinary.com/practicaldev/image/fetch/s--tfs5X4w---/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_880/https://cdn.hashnode.com/res/hashnode/image/upload/v1649373965048/k3ExcTcW5.png)

Voici comment il se présente dans le fichier hello.yml dans un dossier .github/workflows/

```
name: hello-world
on: push
jobs:
  my-job:
    runs-on: ubuntu-latest
    steps:
      - name: my-step
        run: echo "Hello World!"
```

lors du push du projet ce pipeline sera déclenché

# Action  MarketPlace

Certaine action répétitive posséde leurs propre pipeline dédié retrouvable dans le MarketPlace : https://github.com/marketplace?type=actions

# Author : 
Stéphane duboze