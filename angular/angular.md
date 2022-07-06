# ANGULAR

### PRESENTATION

Angular est un framework côté client, open source, basé sur TypeScript. Angular est codirigé par l'équipe du projet « Angular » à Google qui en assure la maintenance.
La première version date de septembre 2016. 

Le Framework est basé sur une architecture du type MVC et permet donc de séparer les données, le visuel et les actions.

Les 3 principales caractéristiques d'Angular sont : 
- Un cadre basé sur des composants
- Une collection de bibliothèques bien intégrées qui couvrent une grande variété de fonctionnalités. Par exemple : le routage ou la gestion des formulaires.
- Une suite d'outils de développement pour vous aider à développer, tester et mettre à jour votre code.

 ________________________________
### ANGULAR != ANGULAR JS

La différence la plus fondamentale entre les deux frameworks est qu’Angular est basé sur Typescript alors que AngularJS est basé sur Javascript. Cela implique essentiellement qu’il y aura des différences dans leurs composants.
Angular a également une syntae différente de AngularJs en se concentrant sur les "[]" pour la liaison des propriétés, et de "( )" pour les liaisons des événements.

Exemple avec la gestion d'évenement :

Avec Angular : `<button (click)="doSomething()">`

Avec AngularJs : `<button ng-click="doSomething()">`

 ________________________________
### DEMARRER UN PROJET ANGULAR 

Installation: `npm install -g @angular/cli`

Aide: `ng help`

Génération d'un projet Angular : `ng new PROJECT-NAME`

Lancement d'un projet Angular :  `ng serve`

Créer un composant : `ng generate component my-new-component`, alias :  `ng g component my-new-component`

 ________________________________
### LES COMPOSANTS 

Dans Angular 2, un composant (component) est un élément réutilisable de l’application, constitué d’une vue et d’un ensemble de traitements associés à cette vue.  Le composant réunit donc au sein d’une même entité la vue et la logique métier associée.
Rappel commande pour créer un componsant : `ng g c mon-composant`

Exemple d'un composant : 

``` import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'exemple';
}
```

Le décorateur @Component a un paramètre JSON qui doit contenir au moins les 3 premiers tags : selector, styleUrls et templateUrl.

- selector : Le sélecteur défini le tag HTML qui agit sur la page web qui le référence. Exemple avec un selector : app-exemple. Dans ce cas le composant sera inséré par : <app-exemple>.
- templateUrl : permet d’associer un fichier externe HTML contenant la structure de la vue du composant.
- styleUrls : spécifier les feuilles de styles CSS associées à ce composant.
 ________________________________
### Les directives
  
En TypeScript, une directive est une classe à laquelle on applique le décorateur @Directive. Il existe deux sortes de directives :

- Les directives structurelles : Elles ont pour but de modifier le DOM en ajoutant, enlevant ou replaçant un élément du DOM. 
- Les directives d'attributs : Elles ont pour but de modifier l'apparence ou le comportement d'un élément.
  

**Directives structurelles :**
  - ngIf : ngIf permet de supprimer ou de recréer  l'élément courant suivant l'expression passée en paramètre. 
Exemple : `<div *ngIf=" X > 0"> Afficher la div</div>`
  - ngFor : ngFor permet de boucler sur un array et d'injecter les éléments dans le DOM. 
Exemple : 
 ```
 <ul>
    <li *ngFor="let item of listItems">{{ item.name }}</li>
</ul>
  ```
- ng Switch : La directive ng-switch vous permet de masquer/afficher des éléments HTML en fonction d'une expression. Les éléments enfants avec la ng-switch-whendirective seront affichés s'ils obtiennent une correspondance, sinon l'élément et ses enfants seront supprimés. Vous pouvez également définir une section par défaut, en utilisant la ng-switch-default directive, pour afficher une section si aucune des autres sections n'obtient de correspondance.
  Exemple : 
 
```
  <div ng-switch="expression">
    <div ng-switch-when="value"></div>
    <div ng-switch-when="value"></div>
    <div ng-switch-when="value"></div>
    <div ng-switch-default>"defaultValue"</div>
</div>
```
</div>

**Directives d'attributs :**
- ngStyle : Il se charge de modifier l'apparence de l'élément porteur.
  Exemple : 
 ` <div [ngStyle]="{color:'red'}">Exemple</div> ` -> le ngStyle transforme juste notre [ngStyle]="{color:'red'}" en style="color: red;".
 
 - Directive personnalisée : Il est également possible de créer nos propres directives. 
  Exemple :

```

import {Directive, Renderer2, ElementRef} from '@angular/core';

@Directive({
  selector: '[appHighlight]'
})
export class HighlightDirective {

  constructor(el: ElementRef, renderer: Renderer2) {
    renderer.setStyle(el.nativeElement, 'color', 'red');
  }

}
```

  ________________________________
### Le routing Angular

Dans le fichier app.componenet.html, on appelle le router-outlet (reference au app-routing module.ts).

```
        <main>
          <router-outlet></router-outlet>
        </main>
```
Dans le fichier app.componenet.html, on appelle le router-outlet (reference au app-routing module.ts)
C’est donc dans le app-routing.module.ts que l’ on créer nos routes.
```
const routes: Routes = [
  {path: "inscription", component: PageSignInComponent}
];
```

La route /inscription, appelle le composant PageSignInComponent.
PageSignInComponent est un composant page, qui contient tous les composants de la page sign-in.

  ________________________________
### Angular Materials

Angular Materials consiste en une suite de composants pré-construits. Contrairement à Bootstrap, qui vous offre des composants que vous pouvez styler comme vous le souhaitez, Angular Material fournit une expérience utilisateur améliorée avec des composants stylisées. 

Commande Installation Materials : 
`ng add @angular/material`

Materials Angular fournit plusieurs composants pré-construits comme :

- Contrôles de formulaire
- Boutons et indicateurs
- Navigation et mise en page
- Popups et modals
- Tableau de données

Exemple d'un composant : 

```
<p>
  Icône avec un badge
  <mat-icon  matBadge = "15"  matBadgeColor = "warn"> home </mat-icon> 
</p>
```

Rendu : 

<img width="63" alt="Capture d’écran 2022-07-06 à 15 56 39" src="https://user-images.githubusercontent.com/57954522/177567309-83988e0a-ab9e-40b7-b4f2-680c043b6ab4.png">


  
