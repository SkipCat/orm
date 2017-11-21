# ORM Project

Ce projet constitue une ébauche d'ORM (ou Mapping Objet-Relationnel) en PHP. Cet outil vous permettra de gérer les relations entre les objets entité de votre projet et une base de données.
En aucun cas cet outil ne remplacera un ORM poussé comme Doctrine ou Eloquent.

Cet ORM a été construit en réponse à l'énoncé suivant :
https://gist.github.com/smwhr/1ad35a93f8002bcdbb35f3413ed38d51

Les instructions ci-dessous vous permettront de vous procurer une copie fonctionnelle du projet sur votre machine.

## Installation

Premièrement, clonez le projet sur votre machine et placez vous dans le dossier **orm/**.

```
git clone git@github.com:SkipCat/orm.git
cd orm/
```

Ensuite, configurez votre base de données :
1. Créez votre base de données.
2. Importez le fichier **database.sql** dans votre base.
3. Modifiez le fichier **parameters.json** situé dans **app/config/** pour qu'il contienne les informations de la base de données.

Pas besoin de surcharger le projet avec <i>composer</i> pour utiliser l'autoload, c'est le fichier **autoload.php** qui s'en charge.



## Tests

Ces tests vous serviront à vous assurer de la connexion à votre base de données et du bon fonctionnement des scripts.

Pour tester une fonctionnalité :

1. Déplacez le fichier correspondant à cette fonctionnalité depuis le dossier **example/** jusqu'à la racine. Si vous ne le déplacez pas à la racine, il ne s'exécutera pas.
2. Exécutez ensuite le fichier déplacé en passant bien les paramètres requis. Par exemple, pour exécuter le fichier **add_film.php**, tapez la commande suivante :

	```
	php add_film.php "Inception" "Christopher Nolan" "2010-07-16" 148 "syfy"
	```

/!\ Attention, certaines méthodes nécessitent des types spécifiques passés en paramètres. Si votre commande ne s'exécute, vérifiez dans la méthode de l'**EntityManager** le type attendu. Un exemple de commande sera également fourni dans chaque fichier.

Pour un souci de légèreté, les différentes méthodes manipulant des requêtes SELECT sont toutes consignées dans un même fichier. Pour exécuter une méthode, il faudra donc la décommenter et commenter les autres.

Note : Les fichiers du dossier **example/** et les entités **Film** et **Showing** ne sont là que pour ces tests. Il n'y a donc aucun problème à leur suppression.



## Utilisation générale

### Ajouter une entité

Il n'y a pour l'instant pas de générateur de classe en ligne de commande. Vous devrez donc le faire manuellement.

Les instructions sont les suivantes :

1. Votre entité doit se situer dans le dossier **src/Entity/**, pour une question de respect de l'architecture.
2. Assurez-vous de lui attribuer un <i>namespace</i> correct, soit ```namespace src\Entity;```.
3. Assurez-vous d'étendre votre entité de l'**EntityManager**, soit ```class YourEntity extends EntityManager```.
4. Attribuez les propriétes suivantes à votre entité (ces propriétés sont nécessaires et contribuent au bon fonctionnement de ce projet) :

	* **$table = 'table_name'**, une <i>string</i> correspondant au nom de la table associée à l'entité.
	* **$relatedTables = ['table_name_1', 'table_name_2']**, un <i>array</i> contenant les noms des tables des entités liées à l'entité. Attention, ce champ n'est valable que pour une relation de type OneToMany, et doit se situer dans l'entité correspondant au "one".
	* **$nameId**, qui représente l'id de l'entité liée. Attention ce champ n'est valable que dans une relation de type ManyToOne et doit se situer dans le fichier de l'entité correspondant au "many".
	* **$id**

5. Les <i>getters</i> et <i>setters</i> sont également nécessaires pour ces champs, à l'exception des <i>setters</i> des champs **$table** et **$relatedTables**.

Pour plus de précision, vous pouvez vous appuyez sur les entités **Film** et **Showing**, qui entretiennent une relation OneToMany (un film possède plusieurs séances).


### Gérer les modèles

Les modèles **ConnectionManager**, **EntityManager** et **LogManager** permettent le bon fonctionnement du projet. Si vous souhaitez les modifier, faites-le avec précaution, à vos risques et périls.

Aucun problème cependant à l'ajout de modèle. Il faut simplement faire attention à instancier le **ConnectionManager** dans chaque méthode pour vérifier la connexion à la base de données.


### Gérer les logs

Chaque requête ou erreur est recensée dans un fichier **request.log** ou **error.log**. Ces fichiers se situent dans le dossier **app/logs/**, et leur écriture est gérée par le **LogManager**.

Ils vous seront utiles pour vérifier le bon déroulement des requêtes SQL, et à debugger le cas échéant.

### Créer une nouvelle table dans la base de données

Pas de contrainte particulière, à l'exception du fait que les colonnes doivent être nommées en **camelCase**.
