Y Banking
=

Explication du projet :
-
Y banking est la fameuse banque en ligne lancé par le milliardaire Elon Musk. 

Voila les différentes entités du projet :

**User**<br>
**Compte**<br>
**Virement**<br>
**Emprunt**<br>

Pour installer le projet :
-
Clonez le repository grâce à cette commande :

````
https://github.com/RomainLENTZ/e-banking.git
````

Par la suite, vous pouvez exécuter la commande :

````
composer install
````

Vous devez aussi créer une base de données et effectuer les migrations. Pour ce faire :
````
php bin/console doctrine:database:create
````

Puis :

````
php bin/console doctrine:migration:migrate
````

Afin d'alimenter la base, vous devez l'alimenter grâce a fixtures en utilisant la commande :
````
php bin/console doctrine:fixtures:load 
````

La base de données est maintenant alimentée. Vous n'avez plus qu'à lancer le serveur en utilisant la commande :
````
 symfony server:start
 ````

Le projet utilise le webpack encore vous pouvez l'installer avec la commande suivante :
````
composer require symfony/webpack-encore-bundle
npm install
````
Pour compiler les assets vous pouvez utiliser la commande :
````
npm run watch
````


Quelques informations en plus :
-

Dans le projet, après avoir éxécuter les fixtures, un compte admin est diponible avec les logins suivants :<br>
**Identifiant** : test1@gmail.com<br>
**Mot de passe** : 123456

Tous les comptes ont le meme mot de passe. Deux autres compte n'étant pas admin sont disponible (test2@gmail.com et test3@gmail.com)

Les utilisateurs avec cette application on la possibilité de :<br>
- Consulter leurs compte en banque
- Faire un virement vers un autre compte
- Consulter leurs empruns
- Rembourser un emprun

Les admins peuvent en plus : 
- ajouter un compte a un utilisateur (compte courant, compte epargne, compte titre)
- Editer le profile d'un utilisateur
- Ajouter un pret à un utilisateur


Auto évalutation : 
-

J'ai deja pas mal utilisé symfony en entreprise sur des projets relativement complexes (gestion de bien immobilier, avec partie admin utilisant le bundle Sonata et partie public, moteur de recherche de bien...) donc les notions abordées durant ce cours étaient déjà connu et dans l'ensemble maîtrisé. C'est pourquoi je pense que mon niveau en symfony pour ce cours est aux alentours de 3.75-4/5