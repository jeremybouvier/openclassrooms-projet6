# Site Communautaire sur le Snowboard

Réalisation d'un site communautaire dans le cadre d'un projet de formation de développeur d’application PHP/Symphony.
Dans ce site les utilisateurs peuvent consulter, partager et éditer un catalogue de figure de snowboard. Les utilisateurs 
inscrit comme membre ont accès à la création ou modification des figures mais ils peuvent aussi poster des commentaires 
sur chaque figure.
Le projet utilise le Framework Symfony et inclu les tests fonctionnels et unitaires du projet. Les données et la 
structure de la base de donnée du projet sont initialisées grâce à un script Composer. Le projet respect les normes 
PSR1, PSR2, PSR4, PSR7 et son architecture est basée sur le modèle MVC.

### Prérequis

Pour pouvoir utiliser le projet vous aurez besoin de :

* [Mysql 14.14]
* [PHP >7.1]
* [Composer 1.8.5]

### Installation

Pour commencer placez vous dans le répertoire ou vous souhaiter installer le projet.


Télécharger le dossier du projet en faisant un :
```
$ git clone https://github.com/jeremybouvier/openclassrooms-projet6 JimmySweatSnowboard
```
placez vous à la racine du projet  :
```
$ cd JimmySweatSnowboard
```

Mettez a jour les dépendances composer en faisant un :
```
$ composer update
```

Modifiez les paramètres d'accès à la base de donnée en remplaçant cette ligne dans le fichier .env présent à la racine du projet :
```
--> DATABASE_URL=mysql://root:root@127.0.0.1:3306/JimmySweatSite
-----------------------------------------------------------------
--> DATABASE_URL=mysql://user:password@adress:port/JimmySweatSite

```

Modifiez les paramètres de connexion au serveur mail en remplaçant cette ligne dans le fichier .env présent à la racine du projet :
```
--> MAILER_URL=smtp://localhost:25?encryption=&auth_mode=
-----------------------------------------------------------------
```
pour le protocole Gmail utilisez :
```
--> MAILER_URL=gmail://username:password@localhost

```

Placez vous dans le dossier JimmySweatSnowboard et initialisez la base de donnée en faisant un :
```
$ composer fixtures
```

## Consignes d’Exécution

Pour pouvoir visualiser le projet dans votre navigateur vous devez pour commencer lancer votre serveur de Symfony :
```
$ php /bin/console server:run
```

Lancer votre navigateur et saisissez ceci dans la barre d'adresse :
```
http://localhost:8000/
```

Vous aurez alors accès au site communautaire. 
Pour vous connectez à la partie administration utiliser un des comptes déjà créer dans le projet. 

*Compte :*

    login : user0
    email : user0@gmail.com
    Mot de passe : user0
    
## Développé avec

* **Symfony 4.2** 
* **PHP 7.1.3**
* **HTML5 & CSS**
* **Mysql 14.14**
* **Composer 1.8.5** 

## Versioning

Le versioning du projet a été effectué avec git version 2.7.4 , pour chaque étape du développement une branche a 
été créé et finalisé par un Pullrequest.

## Auteur

**Bouvier Jérémy** - Étudiant à Openclassrooms 
 Parcours suivi *Développeur d'application PHP/Symfony*

## Licence

Pas de licence enregistrée.
