# Présentation TypeScript

## Qu'est ce que TypeScript

Pour commencer on peut se demander ce qu'est TypeScript et à quoi il peut servir.
TypeScript est un superset de Javascript (du code JavaScript valide est du code TypeScript valide).

Ensuite, TypeScript est un langage fortement typé, ce qui permet de s'assurer que les bons types sont utilisés, et ce dès la phase de compilation (avant l'exécution).

## Les avantages du TypeScript

### Moins d'erreurs

TypeScript va vous permettre de limiter les erreurs dans votre code et notamment un type d'erreur que l'on rencontre trop souvent souvent.

`Uncaught TypeError : Cannot read properties of undefined (reading ‘ToLowerCase’)`

C’est le genre d’erreur qui peut arriver parce que j’ai peut-être fait une faute de frappe ou parce que j’ai fait une erreur logique.

Le problème de cette erreur se déclenche assez tard dans le code et on ne le remarque pas souvent, il faut remonter la pile d’appel pour pouvoir comprendre l’origine de celle-ci.

Avec typescript si un paramètre n’a pas le bon type on sera directement informé du problème assez tôt et on pourra même le corriger avant que l'erreur ne se produise.

**Exemple :**

La fonction `triggerError` va accéder au champ cat qui doit lui être passé en paramètre et la partie avec le return va afficher sur un navigateur web les différentes balises h1 h2..etc.

Dans le code ci-dessous, j'ai volontairement omis de lui passer ce paramètre pour provoquer une erreur lorsque je clique sur le boutton **"Click me!"** dans le navigateur.

```javascript
import React from "react";
import "./styles.css";

export default function App(){
    const triggerError = props => {
        return props.cat;
    };

    return (
        <div className="App">
            <h1>Hello</h1>
            <h2>Start something</h2>
            <button onClick={() => triggerError()}>Click me!</button>
        </div>
    );
```

Le code ci-dessous en typescript, L'IDE va afficher une erreur sur la fonction **trigerError** de la balise **button** qui demande un argument alors que dans notre cas aucun n'a été fourni.

```typescript
import React from "react";
import "./styles.css";

type test = {
    cat: string;
};

export default function App() {
    const triggerError = {props: Test } => {
        return props.cat;
    };

    return (
        <div className="App">
            <h1>Hello</h1>
            <h2>Start something</h2>
            <button onClick={() => triggerError()}>Click me!</button>
        </div> 
    );
}
```

**Solution :**

L'argument demandé à été inséré dans la fonction **triggerError** de la balise **Button**.

```typescript
import React from "react";
import "./styles.css";

type test = {
    cat: string;
};

export default function App() {
    const triggerError = {props: Test } => {
        return props.cat;
    };

    return (
        <div className="App">
            <h1>Hello</h1>
            <h2>Start something</h2>
            <button onClick={() => triggerError({ cat: "john" })}>Click me!</button>
        </div> 
    );
}
```

Dans cet exemple concret, on voit que Typescript est un outil permettant de réduire fortement les erreurs en production, à la différence du JS ou on doit être plus rigoureux lorsque l'on code.

### Une meilleure documentation

Du code écrit en Typescript permet avoir d’avoir une meilleure auto-complétion et une meilleure documentation (à travers le typage fort on saura quel type de paramètre est attendu par les fonctions).

Cette doc des types sera beaucoup plus exhaustive que ce qu’il est possible de faire avec le JsDoc.

### Une cible unique

Un autre avantage de Typescript c’est qu'on peut facilement cibler une version spécifique de Typescript et lui faire exporter le code de n’importe quelle version de Javascript, Il peut remplacer des outils comme babel par exemple.

## Les inconvénients

Typescript va être un outil supplémentaire qui entre dans le code / navigateur / serveur, il pourra plus directement coller une fonction dans le navigateur pour le tester par exemple et on va devoir trouver des adapters typescript, cependant dans le pire des cas on peut toujours convertir notre code en Js pour faire fonctionner l’outil de notre choix.

Pour que Typescript fonctionne complètement, il a besoin de connaître le type de tous les éléments, ça peut parfois poser problème quand on choisit une librairie qui n’est écrite par exemple que en JS, il faut donc être attentif aux librairies que on utilise.

Enfin, le dernier problème réside dans le mélange entre le code et les types. Parfois ce mélange peut rendre le code moins lisible.

```typescript
Function push<T, U>(items : readonly T[], item : U ) : (T | U) [] {
    return [...items, item]
}
```

On aura la possibilité de créer des alias pour mitiger ce problème. Bien que cette pratique est rare, vous pouvez aussi déplacer les types dans les commentaires si vous ne souhaitez pas les mélanger à votre code.
