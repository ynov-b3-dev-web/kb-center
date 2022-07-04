# Présentation Routing / MultiRouting / HashLink

Sommaire :
1. [React Router Dom](#react-router-dom)
2. [Multi Routing](#multirouting)
3. [HashLink](#hashlink)

## React Router Dom

Tout d'abord il faut lancer un projet react et télécharger le package de react router dom :

`npm install react-router-dom@6`

Une fois l'installation du package terminé nous allons l'appeler dans notre page ainsi que ses composants.

### Création des Routes

`import { BrowserRouter, Routes, Route } from "react-router-dom";`

`BrowserRouter` : le composant qui va entourer tous les autres composants qui font parti de react rooter dom et qui vont changer avec les pages

`Routes` : le composant qui va entourer tous les composants route

`Route` : le composant dans lequel on va définir l'url et le le composant à afficher dans cette page ("index" sert à définir quelle est la page de base à afficher / "path" sert à définir le tag des pages)

Voila comment se présente une arborescene normal de react router dom :

```
<BrowserRouter>
    <Routes>
        <Route index element={<Home />} />
        <Route path="teams" element={<Teams />} />
    </Routes>
</BrowserRouter>
```

### Navigation sur le site

Afin de naviguer à l'intérieur du site nous allons devoir implémenter des liens vers les différentes pages du site, pour cela nous allons commencer par appeler le composant permetant la navigation :

`import { Link } from "react-router-dom;`

Le link se comporte comme une balise <a> en HTML avec une argument `to` qui correspond au `path` de la route souhaité.

Exemple :

```
function Home() {
  return (
    <div>
      <h1>Home</h1>
      <nav>
        <Link to="/">Home</Link> |{" "}
        <Link to="about">About</Link>
      </nav>
    </div>
  );
}
```
## MultiRouting

Afin de permettre un changement d'élément dans une page il faut légérement modifier les composants Route et Link

Pour le composant Route il faut rajouter `/*` derrière le path d'origine, cela signifie qu'il peut y avoir d'autre Routes derrière cette Route.

Exemple :

`<Route path="/Voyage_1/*" element={<VoyageAlbum name="Voyage 1" />} />`

Et à l'intérieur du composant Route d'origine (avec le `/*`) il faut mettre une nouvelle Route qui aura path l'élément qui s'ajoutera à notre path d'origine.

Pour le composant Link il faut renseigner le path de la deuxième balise Route.

Exemple Concret : [Projet Travel Earth](https://github.com/ynov-b3-dev-web/travel-earth-front)

## HashLink

Pour faire des liens internes à notre (pour les utiliser sur un site one page par exemple) il faut installer un autre package car react router dom ne le fais pas de lui même :

`npm install --save react-router-hash-link`

Une fois le package installé il suffit de remplacer l'import des Link de react router dom par ceci :

`import { HashLink as Link } from "react-router-hash-link";`

Une fois l'importe il suffit de rajouter à vos Link le hashlink de votre choix (correspondant à un id d'un de vos composant) :

```
<Link to="/#home" className="navbar_link">
	Accueil
</Link>
```

Exemple Concret : [Site Florian Berthier](https://github.com/Orthoceras69/florian-berthier-website)
