# Projet-o-fajitas


## Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants :
- PHP : 8.*
- Composer
- Symfony CLI
 

## Installation

1. Clonez le dépôt 

2. Installez les dépendances avec Composer :
  
 ```bash

  cd votre-projet
  composer install

  ```
3. Créez votre .env.local 

4. Créez et migrez la base de données
   
 ```bash

   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate

  ```
<<<<<<< HEAD

=======
5. Chargez les fixtures
   
 ```bash

   php bin/console doctrine:fixtures:load

  ```
>>>>>>> 721767fd6ac82932d683d374e90e1f88512d1c5e

