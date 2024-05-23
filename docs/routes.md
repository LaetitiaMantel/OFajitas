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
| `/login`                  | `login`            | `GET`        | `SecurityController` | `login`  |            |
| `/logout`                 | `logout`           | `GET`        | `SecurityController` | `logout` |            |
| `/account`                | `front_user_index`     | `GET`        | `UserController`     | `index`  |            |
| `/account`                | `front_user_index`     | `POST`       | `UserController`     | `index`  |            |
| `/account/edit`           | `front_user_edit`      | `GET`        | `UserController`     | `edit`   |            |
| `/account/edit`           | `front_user_edit`      | `POST`       | `UserController`     | `edit`   |            |
| `/account/delete`         | `front_user_delete`    | `POST`       | `UserController`     | `delete` |            |
| `favoris`                 | `front_favorite_index` | `GET`        | `FavoriteController` | `index`  | Mes favoris|    
       |





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

# Routes du Front

| Nom                             | Méthode HTTP | URL                           |
| ------------------------------- | ------------ | ----------------------------- |
| front_brand_show                | ANY          | /marque/{slug}                |
| front_cart_index                | GET          | /panier/                      |
| front_cart_add                  | POST         | /panier/ajouter/{id}          |
| front_cart_remove               | POST         | /panier/supprimer/{id}        |
| front_cart_empty                | GET          | /panier/vider                 |
| front_cart_adjust_quantity_ajax | POST         | /panier/ajuster-quantite/{id} |
| front_cart_get_cart_count       | POST         | /panier/count                 |
| front_cart_get_total            | POST         | /panier/total                 |
| front_cart_get_product_totals   | GET          | /panier/get_product_totals    |
| front_category_show             | ANY          | /categorie/{slug}             |
| front_favorite_index            | ANY          | /favoris/                     |
| front_favorite_add              | GET/POST     | /favoris/ajouter/{id}         |
| front_favorite_delete           | POST         | /favoris/supprimer/{id}       |
| front_favorite_empty            | GET          | /favoris/vider                |
| front_main_home                 | ANY          | /                             |
| front_main_search               | ANY          | /search                       |
| front_main_contact              | ANY          | /contact                      |
| front_main_qsn                  | ANY          | /qui-sommes-nous              |
| front_order_confirm             | GET/POST     | /commandes/confirmation       |
| front_order_payment             | GET/POST     | /commandes/process            |
| front_order_payment_done        | GET/POST     | /commandes/payment/{orderRef} |
| front_order_validate            | GET          | /commandes/validate           |
| front_product_index             | ANY          | /produit/                     |
| front_product_show              | ANY          | /produit/{slug}               |
| front_product_random_products   | ANY          | /produit/random-products      |
| front_review_new                | ANY          | /produit/{slug}/critique      |
| front_user_info                 | ANY          | /information                  |
| front_user_new                  | GET/POST     | /nouveau                      |
| front_user_edit                 | GET/POST     | /modifer/{email}              |
| front_user_delete               | POST         | /supprimer/{email}            |
| front_user_order_info           | ANY          | /mes-achats                   |
| front_user_connecter            | ANY          | /connecter                    |
| login                           | ANY          | /connexion                    |
| logout                          | ANY          | /logout                       |

# Routes du Back

| Nom                  | Méthode HTTP | URL                      |
| -------------------- | ------------ | ------------------------ |
| back_category_show   | GET          | /back/category/{id}      |
| back_brand_new       | GET/POST     | /back/brand/new          |
| back_brand_show      | GET          | /back/brand/{id}         |
| back_brand_edit      | GET/POST     | /back/brand/{id}/edit    |
| back_brand_delete    | POST         | /back/brand/{id}         |
| back_category_index  | GET          | /back/category/          |
| back_category_new    | GET/POST     | /back/category/new       |
| back_brand_index     | GET          | /back/brand/             |
| back_category_edit   | GET/POST     | /back/category/{id}/edit |
| back_category_delete | POST         | /back/category/{id}      |
| back_main_search     | ANY          | /back/search             |
| back_product_index   | GET          | /back/product/           |
| back_product_new     | GET/POST     | /back/product/new        |
| back_product_show    | GET          | /back/product/{id}       |
| back_product_edit    | GET/POST     | /back/product/{id}/edit  |
| back_product_delete  | POST         | /back/product/{id}       |
| back_user_index      | GET          | /back/user/              |
| back_user_new        | GET/POST     | /back/user/new           |
| back_user_show       | GET          | /back/user/{id}          |
| back_user_edit       | GET/POST     | /back/user/{id}/edit     |
| back_user_delete     | POST         | /back/user/{id}          |
