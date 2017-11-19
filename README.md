# ORM Project

Ce projet constitue une ébauche d'ORM (ou Mapping Objet-Relationnel) en PHP. Cet outil vous permettra de faire la relation entre les objets entité de votre projet et une base de données.
En aucun cas cet outil ne remplacera un ORM poussé comme Doctrine ou Eloquent.

Cet ORM a été construit en réponse à l'énoncé suivant :
https://gist.github.com/smwhr/1ad35a93f8002bcdbb35f3413ed38d51

Les instructions ci-dessous vous permettront de vous procurer une copie fonctionnelle du projet sur votre machine.

## Installation

Premièrement, clonez le projet sur votre machine et placez vous dans le dossier orm/.

```
git clone git@github.com:SkipCat/orm.git
cd orm/
```

Ensuite, configurez votre base de données :
* Importez le fichier .sql.
* Modifiez le fichier parameters.json situé dans app/config/ pour qu'il contienne les informations de la base de données.
* Décommentez le fichier parameters.json dans le fichier .gitignore.


## Tests

Ces tests vous serviront à vous assurer de la connexion à votre base de données et du bon fonctionnement des scripts.
Exécutez les fichiers dans le dossier example/ en définissant bien les paramètres requis. Par exemple, pour exécuter le fichier add_film.php, tapez la commancde suivante :

```
php run example/add_film.php "Inception" "Christopher Nolan" "2010-07-16" 148 "syfy" 
```

Les fichiers du dossier example/ et les entity Film.php et Showing.php ne sont là que pour ces tests. Il n'y a donc aucun problème à leur suppression.

## Utilisation générale

### Ajouter une entité

Votre entité devra se situer dans le dossier src/Entity. Assurez vous de lui attribuer un <i>namespace</i>.

Chaque entité possède des propriétés qui sont nécessaires au bon fonctionnement de ce projet. Ces propriétés sont les suivantes :
* **$table = 'table_name'**, une <i>string</i> correspondant au nom de la table associée à l'entité.
* **$relatedTables = ['table_name_1', 'table_name_2']**, un <i>array</i> contenant les noms des tables des entités liées à l'entité. Attention, ce champ n'est valable que pour une relation de type OneToMany, et doit se situer dans l'entité correspondant au "one".
* **$nameId**, qui représente l'id de l'entité liée. Attention ce champ n'est valable que dans une relation de type ManyToOne et doit se situer dans le fichier de l'entité correspondant au "many".
* **$id**

Les getters et setters sont également nécessaires pour ces champs, à l'exception des setters des champs **$table** et **$relatedTables**

### Gérer les modèles

Les modèles ConnectionManager, EntityManager et LogManager permettent le bon fonctionnement du projet. Si vous souhaitez les modifier, faites-le à vos risques et périls.

Aucun problème cependant à l'ajout de modèle.

### Gérer les logs

Chaque requête ou erreur est recensée dans un fichier request.log ou error.log.
Ces fichiers se situent dans le dossier app/logs/, et leur écriture est gérée par le LogManager.