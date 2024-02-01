# Routes de l'application

| URL                    | Nom                      | Méthode HTTP | Contrôleur           | Méthode  | Titre HTML |
| ---------------------- | ------------------------ | ------------ | -------------------- | -------- | ---------- |
| `/`                    | `front_main_home`        | `GET`        | `MainController`     | `home`   |            |
| `/search`              | `front_main_search`      | `GET`        | `MainController`     | `search` |            |
| `/categories`          | `front_categories_index` | `GET`        | `CategoryController` | `index`  |            |
| `/categories/{id}`     | `front_categories_show`  | `GET`        | `CategoryController` | `show`   |            |
| `/brands`              | `front_brands_index`     | `GET`        | `BrandController`    | `index`  |            |
| `/brands/{id}`         | `front_brands_show`      | `GET`        | `BrandController`    | `show`   |            |
| `/products`            | `front_products_index`   | `GET`        | `ProductController`  | `index`  |            |
| `/products/{id}`       | `front_products_show`    | `GET`        | `ProductController`  | `show`   |            |
| `/cart`                | `front_cart_index`       | `GET`        | `CartController`     | `index`  |            |
| `/cart/add/{id}`       | `front_cart_add`         | `POST`       | `CartController`     | `add`    |            |
| `/cart/delete/{id}`    | `front_cart_delete`      | `POST`       | `CartController`     | `delete` |            |
| `/cart/empty`          | `front_cart_empty`       | `GET`        | `CartController`     | `empty`  |            |
| `/login`               | `app_login`              | `GET`        | `SecurityController` | `login`  |            |
| `/logout`              | `app_logout`             | `GET`        | `SecurityController` | `logout` |            |
| `/account`             | `front_user_index`       | `GET`        | `UserController`     | `index`  |            |
| `/account/edit/{id}`   | `front_user_edit`        | `POST`       | `UserController`     | `edit`   |            |
| `/account/delete/{id}` | `front_user_delete`      | `POST`       | `UserController`     | `delete` |            |