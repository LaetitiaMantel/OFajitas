# Routes de l'application

| URL                       | Nom                    | Méthode HTTP | Contrôleur           | Méthode  | Titre HTML |
| ------------------------- | ---------------------- | ------------ | -------------------- | -------- | ---------- |
| `/`                       | `front_main_home`      | `GET`        | `MainController`     | `home`   |            |
| `/recherche`              | `front_main_search`    | `GET`        | `MainController`     | `search` |            |
| `/categorie/{slug}`       | `front_category_show` | `GET`        | `CategoryController` | `show`   |            |
| `/marque/{slug}`          | `front_brands_show`    | `GET`        | `BrandController`    | `show`   |            |
| `/produits`               | `front_products_index` | `GET`        | `ProductController`  | `index`  |            |
| `/produit/{slug}`         | `front_products_show`  | `GET`        | `ProductController`  | `show`   |            |
| `/panier`                 | `front_cart_index`     | `GET`        | `CartController`     | `index`  |            |
| `/panier/ajouter{slug}`   | `front_cart_add`       | `POST`       | `CartController`     | `add`    |            |
| `/panier/supprimer{slug}` | `front_cart_delete`    | `POST`       | `CartController`     | `delete` |            |
| `panier/vider`            | `front_cart_empty`     | `GET`        | `CartController`     | `empty`  |            |
| `/login`                  | `app_login`            | `GET`        | `SecurityController` | `login`  |            |
| `/logout`                 | `app_logout`           | `GET`        | `SecurityController` | `logout` |            |
| `/account`                | `front_user_index`     | `GET`        | `UserController`     | `index`  |            |
| `/account`                | `front_user_index`     | `POST`       | `UserController`     | `index`  |            |
| `/account/edit`           | `front_user_edit`      | `GET`        | `UserController`     | `edit`   |            |
| `/account/edit`           | `front_user_edit`      | `POST`       | `UserController`     | `edit`   |            |
| `/account/delete`         | `front_user_delete`    | `POST`       | `UserController`     | `delete` |            |
| `favoris`                 | `front_favorite_index` | `GET`        | `FavoriteController` | `index`  | Mes favoris|           |





# Routes de l'application

| URL                    | Déscription | Méthode HTTP |
| ---------------------- | ----------- | ------------ |
| `/`                    |             | `GET`        |
| `/search`              |             | `GET`        |
| `/categories`          |             | `GET`        |
| `/categories/{slug}`   |             | `GET`        |
| `/brands`              |             | `GET`        |
| `/brands/{slug}`       |             | `GET`        |
| `/products`            |             | `GET`        |
| `/products/{slug}`     |             | `GET`        |
| `/cart`                |             | `GET`        |
| `/cart/add/{id}`       |             | `POST`       |
| `/cart/delete/{id}`    |             | `POST`       |
| `/cart/empty`          |             | `GET`        |
| `/login`               |             | `GET`        |
| `/logout`              |             | `GET`        |
| `/account`             |             | `GET`        |
| `/account/edit/{id}`   |             | `POST`       |
| `/account/delete/{id}` |             | `POST`       |
| `/favorite`             |             | `GET`        |

| URL                        | Déscription | Méthode HTTP |
| -------------------------- | ----------- | ------------ |
| `/`                        |             | `GET`        |
| `/recherche`               |             | `GET`        |
| `/categorie/{slug}`        |             | `GET`        |
| `/marque/{slug}`           |             | `GET`        |
| `/produits`                |             | `GET`        |
| `/produit/{slug}`          |             | `GET`        |
| `/panier`                  |             | `GET`        |
| `/panier/ajouter/{slug}`   |             | `POST`       |
| `/panier/supprimer/{slug}` |             | `POST`       |
| `/panier/vider`            |             | `GET`        |
| `/login`                   |             | `GET`        |
| `/logout`                  |             | `GET`        |
| `/account`                 |             | `GET`        |
| `/account`                 |             | `POST`       |
| `/account/edit`            |             | `GET`        |
| `/account/edit`            |             | `POST`       |
| `/account/delete`          |             | `POST`       |
| `/favorite`                |             | `GET`        | 

