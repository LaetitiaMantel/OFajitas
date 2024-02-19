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

5. Chargez les fixtures
   
 ```bash

   php bin/console doctrine:fixtures:load

    ```

