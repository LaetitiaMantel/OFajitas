# Dictionnaire de données

## Table des produits

| Champ       | Type          | Spécificités                       | Description                    |
| ----------- | ------------- | ---------------------------------- | ------------------------------ |
| id          | INT           | PRIMARY KEY, NOT NULL              | identifiant du produit         |
| name        | VARCHAR(128)  | NOT NULL                           | nom du produit                 |
| description | TEXT          | NOT NULL                           | descirption du produit         |
| picture     | VARCHAR(2083) | NOT NULL                           | image du produit               |
| price       | INT           | NOT NULL                           | prix du produit en centime     |
| rating      | DECIMAL (1,1) | NOT NULL                           | note du produit                |
| status      | BOOL          | NOT NULL                           | disponibilité du produit       |
| slug        | VARCHAR(255)  | NOT NULL                           | slug du produit                |
| createdAt   | DATETIME      | NOT NULL, DEFAULT CURRENT_DATETIME | date de création du produit    |
| updatedAt   | DATETIME      | NOT NULL, DEFAULT CURRENT_DATETIME | date de mise a jour du produit |
<<<<<<< HEAD
| brand_id    | ENTITY        | NOT NULL                           | marque du produit              |
| category_id | ENTITY        | NOT NULL                           | catégorie du produit           |
=======
| brand       | ENTITY        | NOT NULL                           | marque du produit              |
| category    | ENTITY        | NOT NULL                           | catégorie du produit           |
>>>>>>> 26c1c138995b6e3a5cd1b38a5e51d3492f5d446a

## Table des catégories

| Champ      | Type          | Spécificités                       | Description                         |
| ---------- | ------------- | ---------------------------------- | ----------------------------------- |
| id         | INT           | PRIMARY KEY, NOT NULL              | identifiant de la catégorie         |
| name       | VARCHAR(128)  | NOT NULL                           | nom de la catégorie                 |
| picture    | VARCHAR(2083) | NOT NULL                           | image de la catégorie               |
| home_order | INT           | NOT NULL                           | ordre d'affichage de la catégorie   |
| slug       | VARCHAR (255) | NOT NULL                           | slug de la catégorie                |
| createdAt  | DATETIME      | NOT NULL, DEFAULT CURRENT_DATETIME | date de création de la catégorie    |
| updatedAt  | DATETIME      | NOT NULL, DEFAULT CURRENT_DATETIME | date de mise a jour de la catégorie |

## Table des marques

| Champ     | Type          | Spécificités                       | Description                      |
| --------- | ------------- | ---------------------------------- | -------------------------------- |
| id        | INT           | PRIMARY KEY, NOT NULL              | identifiant de la marque         |
| name      | VARCHAR(128)  | NOT NULL                           | nom de la marque                 |
| slug      | VARCHAR (255) | NOT NULL                           | slug de la marque                |
| createdAt | DATETIME      | NOT NULL, DEFAULT CURRENT_DATETIME | date de création de la marque    |
| updatedAt | DATETIME      | NOT NULL, DEFAULT CURRENT_DATETIME | date de mise a jour de la marque |

## Table des clients

| Champ              | Type          | Spécificités          | Description                             |
| ------------------ | ------------- | --------------------- | --------------------------------------- |
| id                 | INT           | PRIMARY KEY, NOT NULL | identifiant de l'utilisateur            |
| email              | VARCHAR(128)  | NOT NULL              | email de l'utilisateur                  |
| phone number       | INT (10)      | NOT NULL              | Numéro  de l'utilisateur                |
| roles              | VARCHAR (255) | NOT NULL              | role de l'utilisateur                   |
| password           | VARCHAR(255)  | NOT NULL              | mot de passe de l'utilisateur           |
<<<<<<< HEAD
| postal code        | INT (5)       | NOT NULL              | code postale  de l'utilisateur          |
=======
| zip code           | INT (5)       | NOT NULL              | code postale  de l'utilisateur          |
>>>>>>> 26c1c138995b6e3a5cd1b38a5e51d3492f5d446a
| adress             | VARCHAR (255) | NOT NULL              | adresse  de l'utilisateur               |
| address supplement | VARCHAR (255) | NULL                  | complément d'adresse   de l'utilisateur |
| city               | VARCHAR(45)   | NOT NULL              | nom de la ville de l'utilisateur        |

## Table des commandes

| Champ      | Type         | Spécificités          | Description                  |
| ---------- | ------------ | --------------------- | ---------------------------- |
| id         | INT          | PRIMARY KEY, NOT NULL | identifiant de la commande   |
| product_id | ENTITY       | NOT NULL              | identifiant du produit       |
| name       | VARCHAR(128) | NOT NULL              | Nom des produits commandés   |
| Price      | int          | NOT NULL              | prix  des produits commandés |
<<<<<<< HEAD
| user_id    | ENTITY       | NOT NULL              | identifiant de l'utilisateur |
=======
| user       | ENTITY       | NOT NULL              | identifiant de l'utilisateur |
>>>>>>> 26c1c138995b6e3a5cd1b38a5e51d3492f5d446a

## Table des paniers

| Champ      | Type   | Spécificités          | Description                    |
| ---------- | ------ | --------------------- | ------------------------------ |
| id         | INT    | PRIMARY KEY, NOT NULL | identifiant du panier          |
| product_id | ENTITY | NOT NULL              | identifiant du produit         |
| quantity   | int    | NOT NULL              | Quantité des produits commandé |
<<<<<<< HEAD
| user_id    | ENTITY | NOT NULL              | identifiant de l'utilisateur   |

=======
| user       | ENTITY | NOT NULL              | identifiant de l'utilisateur   |
>>>>>>> 26c1c138995b6e3a5cd1b38a5e51d3492f5d446a
