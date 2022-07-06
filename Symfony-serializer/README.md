# Travailler avec le composant Serializer de Symfony

**Tout d'abord, une explication de ce terme :**

C'est simplement le fait de transformer un objet dans un format spécifique *(Json, Yaml..)*.

Quand on re-transforme à nouveau cet objet dans le format d'origine on dit que l'on **désérialise**.

Il est tout à fait possible développer son API sur Symfony sans passer par API Platform !

Dans le schéma ci-dessous la sérialisation transforme l'objet en array (normalisation) avant l'encodage tandis que la désérialisation fait l'inverse.
![alt](https://www.novaway.fr/uploads/media/serializer_workflow.png)

## Présentation de ses normalizers et décodeurs

Lorsqu'on travaille avec ce composant on utilise majoritairement 3 normalizers :

- **ObjectNormalizer** qui permet d'accéder aux propriétés de l'objet. Il permet de chercher les propriétés et méthodes publiques de
l'objet (GET/SET/HAS/IS/ADD/REMOVE)
- **GetSetMethodNormalizer** utilise les getter et setter de l'objet, cherche toutes les méthodes publiques ayant en nom get suivi d'un nom de propriété.
- **PropertyNormalizer** qui utilise Php reflexion pour accéder aux propriétés de l'objet, qu'elles soient publiques ou privées.

Il est possible de créer un normalizer personnalisé faisant implémenter à notre classe l'interface `NormalizerInterface`, la création du tag étant automatique :

```yml
new_normalizer:
    class: Path\to\class
    public: false
    tags: [serializer.normalizer]
```

## Utilisation du Serializer

Une fois dans votre Controller il vous faudra :

- Injecter le Serializer (ou bien, si en-dehors d'une application Symfony, l'instancier manuellement en lui fournissant les normalizers et encoders)
- Appeler la méthode serialize du serializer avec l'objet et le format en paramètres.

```php
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
//...
      $encoders = array(new JsonEncoder());
      $normalizers = array(new ObjectNormalizer());
      $serializer = new Serializer($normalizers, $encoders);
      $productSerialized = $serializer->serialize($product, 'json');
//...
```

En ce qui concerne la **désérialisation**,  il faut appeler la méthode deserialize avec en paramètre les données sérialisées, la classe et le format :

```php
$productDeserialized = $serializer->deserialize($productSerialized, Product::class, 'json');
```

Si vous souhaitez le faire directement dans un objet existant :

```php
$productDeserialized->deserialize($productSerialized, Product::class, 'json', array('object_to_populate' => $product));
```
