# Présentation Vue 3

## Qu'est-ce que Vue ?

Vue est un framework front web. Il fait partie des technologies les plus utilisées pour le rendu de page web, avec React ou Angular.
Les composants en Vue sont composés d'une balise `template` et d'une balise `script`. La balise template contient le rendu visuel du composant. La balise script contient la logique du composant :

```js
<template>
  <div>
    je suis un composant
  </div>
</template>
  
<script>
  ....states, méthodes....
</script>
```

## Option et composition

Vue 3 a deux façons de fonctionner, soit en option soit en composition. Le mode de fonctionnement en option nous permet de déclarer les states (états utilisés pour le rendu) dans une propriété data :

```js
<script>
export default {
  data() {
    return {
      question: '',
      answer: 'Questions usually contain a question mark. ;-)'
    }
  }
}
</script>
```
  
Dans l'exemple ci-dessus je déclare deux states, un state question et un state answer.

Pour les méthodes on utilise le même fonctionnement :

```js
<script>
export default {
  data() {
    return {
      question: '',
      answer: 'Questions usually contain a question mark. ;-)'
    }
  },
  methods: {
    async getAnswer() {
      this.answer = 'Thinking...'
      try {
        const res = await fetch('https://yesno.wtf/api')
        this.answer = (await res.json()).answer
      } catch (error) {
        this.answer = 'Error! Could not reach the API. ' + error
      }
    }
  }
}
</script>
```

Dans l'exemple ci-dessus je déclare une méthode `getAnswer`.

Personnellement je trouve cette écriture trop longue et je préfère utiliser le mode composition :

```js
<script setup>
const question = ref('')
const answer = ref('Questions usually contain a question mark. ;-)')

function getAnswer() {
  answer.value = 'Thinking...'
  try {
    const res = await fetch('https://yesno.wtf/api')
    answer.value = (await res.json()).answer
  } catch (error) {
    answer.value = 'Error! Could not reach the API. ' + error
  }
}
</script>
```

L'exemple ci-dessus contient aussi un state question et un state answer ainsi qu'une méthode getAnswer. On ajoute `setup` dans la balise script pour éviter d'avoir à faire un `export default`.

Au final, c'est presque comme utiliser une classe :)

## Les computed ou valeurs calculées

Les computed sont des valeurs qui vont être calculées dynamiquement en fonction des valeurs réactives (des states ou d'autres computed) qu'elles contiennent :

```js
<script setup>
const author = ref({
  name: 'John Doe',
  books: [
    'Vue 2 - Advanced Guide',
    'Vue 3 - Basic Guide',
    'Vue 4 - The Mystery'
  ]
})

const publishedBooksMessage = computed(() => author.value.books.length > 0 ? 'Yes' : 'No')
</script>

<template>
  <p>Has published books:</p>
  <span>{{ publishedBooksMessage }}</span>
</template>
```

Dans l'exemple ci-dessus on calcule dynamiquement le nombre de livres de l'auteur. Si on change la valeur `author`, le computed `publishedBooksMessage` va être de nouveau calculé et affiché.

Les computed sont une des clés des performance de vue.

## Les composables

Les composables permettent de réutiliser du code :

> useUserRole.ts

```js
import { UserRoles } from '~/enums/users/UserRoles'
import { useConnectedUser } from '~/stores/users/connected'

export function useUserRole() {
  const { connectedUser } = useConnectedUser()
  const isUser = computed(() => connectedUser.role === UserRoles.user)
  const isVisitor = computed(() => connectedUser.role === UserRoles.visitor)
  const isValidator = computed(() => connectedUser.role === UserRoles.validator)
  const isAdmin = computed(() => connectedUser.role === UserRoles.admin)

  return {
    isUser,
    isVisitor,
    isValidator,
    isAdmin,
  }
}
```

Par exemple, on peut utiliser ce composable pour récupérer dynamiquement le type d'utilisateur connecté sur notre application :

```js
<script setup>
import { useUserRole } from '~/composables/useUserRole'

const { isValidator } = useUserRole()
</script>

<template>
  <div>
    {{ isValidator }}
  </div>
</template>
```

Dans l'exemple ci-dessus on affiche true si l'utilisateur est de type validator et false si il ne l'est pas. Pour ce faire, il nous suffit d'importer notre composable `useUserRole` et de le décomposer pour récupérer les valeurs qu'il contient.

## VueUse

En parlant de composables... [VueUse](https://vueuse.org/) est une librairie qui contient une collection de composables très pratiques.

### createGlobalState

Actuellement, le composable que je préfère utiliser est celui que nous retourne la méthode `createGlobalState`. Cette méthode permet d'avoir une variable globale changeable partout dans votre code. Pour moi fini les stores, j'utilise uniquement ce composable :) :

> store.ts

```js
import { createGlobalState, useStorage } from '@vueuse/core'

export const useBanana = createGlobalState(
  () => ref('im an initial banana'),
)
```

On déclare une variable globale que l'on utilise comme un composable.

On peut même enregistrer dynamiquement notre state en session locale :). Pour ce faire on peut utiliser un autre composable de VueUse, `useStorage` :

> store.ts

```js
export const useBanana = createGlobalState(
  () => useStorage('banana', 'im an initial banana'),
)
```

VueUse contient beaucoup de composables très utiles comme `useWindowSize`, `useGeolocation`...

Quelques liens :

- [useStorage](https://vueuse.org/core/usestorage/#usestorage)
- [Computed Vue](https://vuejs.org/guide/essentials/computed.html#basic-example)
- [Composables](https://vuejs.org/guide/reusability/composables.html)
