 

// Fonction pour effectuer une requête AJAX générique
function sendAjaxRequest(route, method, successCallback, errorCallback) {
  fetch(route, {
    method: method,
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur lors de la requête AJAX");
      }
      return response.json();
    })
    .then(successCallback)
    .catch(errorCallback);
}

  // Fonction pour gérer les événements d'ajout au panier et mise à jour du compteur
  function handleAddToCartEvent(button, productId) {
    const flashMessagesContainer = document.getElementById(
      "flashMessagesContainer-" + productId
    );
    const route = button.getAttribute("data-route");

    sendAjaxRequest(
      route.replace("{id}", productId),
      "POST",
      (data) => {
        flashMessagesContainer.innerHTML = data.message;
        setTimeout(() => (flashMessagesContainer.innerHTML = ""), 3000);
        getCartCount();
      },
      (error) => console.error("Erreur lors de la requête AJAX :", error)
    );
  }

  // Fonction pour gérer les événements de suppression du panier et mise à jour du compteur
  function handleDeleteFromCartEvent(button, productId) {
    const route = button.getAttribute("data-route");

    sendAjaxRequest(
      route.replace("{id<\\d+>}", productId),
      "POST",
      (data) => {
        const productCard = button.closest(".product-card");
        if (productCard) {
          productCard.style.opacity = 0;
          setTimeout(() => {
            productCard.remove();
            getCartCount();

            getCartTotal(); // Appel de getCartTotal après la suppression du produit

            // Après avoir mis à jour le total, vérifiez si le panier est vide
            const cartTotalContainer = document.getElementById(
              "cart-total-container"
            );
            const cartTotal = parseFloat(cartTotalContainer.innerText);
          }, 500);
        }
      },
      (error) => console.error("Erreur lors de la requête AJAX :", error)
    );
  }
  // Fonction pour vider le panier et mise à jour du compteur
  function emptyCartEvent(route) {
    const flashMessagesContainer = document.getElementById(
      "flashMessagesContainer"
    );

    sendAjaxRequest(
      route,
      "GET",
      (data) => {
        flashMessagesContainer.innerHTML = data.message;

        document
          .querySelectorAll(".product-row")
          .forEach((row) => row.remove());

        setTimeout(() => (flashMessagesContainer.innerHTML = ""), 3000);
        getCartCount();
      },
      (error) => console.error("Erreur lors de la requête AJAX :", error)
    );
  }

  // Fonction pour obtenir le nombre d'articles dans le panier
  function getCartCount() {
    const cartCountContainer = document.getElementById("cart-count");

    sendAjaxRequest(
      cartCountUrl,
      "POST",
      (data) => {
        const cartCount = data.cartCount !== undefined ? data.cartCount : 0;
        localStorage.setItem("cartCount", cartCount);
        cartCountContainer.innerText = cartCount > 0 ? cartCount : "0";
      },
      (error) =>
        console.error(
          "Erreur lors de la requête AJAX pour obtenir le nombre d'articles dans le panier :",
          error
        )
    );
  }

  // Fonction pour obtenir le total du panier
  function getCartTotal() {
    const cartTotalContainer = document.getElementById("cart-total-container");

    sendAjaxRequest(
      cartTotalUrl,
      "POST",
      (data) => {
        cartTotal = data.cartTotal !== undefined ? data.cartTotal : 0;
        localStorage.setItem("cart-total", cartTotal);

        cartTotalContainer.innerText = cartTotal + " €";
      },
      (error) => {
        console.error("AJAX error:", error);
      }
    );
  }

  // Gestion de l'événement de déplacement vers les favoris
  document.addEventListener("click", function (event) {
    if (event.target.classList.contains("moveToFavoritesButton")) {
      event.preventDefault();

      const productId = event.target.getAttribute("data-product-id");
      const addToFavoriteRoute = event.target.getAttribute("data-add-route");
      const deleteFromCartRoute =
        event.target.getAttribute("data-delete-route");

      console.log("Add to Favorite Route:", addToFavoriteRoute);
      console.log("Delete from Cart Route:", deleteFromCartRoute);

      // Effectuer la requête AJAX pour ajouter aux favoris
      sendAjaxRequest(
        addToFavoriteRoute,
        "GET",
        (data) => {
          console.log("Add to Favorites Success data:", data);

          sendAjaxRequest(
            deleteFromCartRoute,
            "POST",
            (data) => {
              // Gérez la suppression du panier ici si nécessaire
              const productCard = event.target.closest(".product-card");
              if (productCard) {
                productCard.style.opacity = 0;
                setTimeout(() => {
                  productCard.remove();
                  getCartCount();
                  getCartTotal();
                }, 500);
              }
            },
            (error) =>
              console.error(
                "Erreur lors de la requête AJAX pour supprimer du panier :",
                error
              )
          );
        },
        (error) =>
          console.error(
            "Erreur lors de la requête AJAX pour ajouter aux favoris :",
            error
          )
      );
    }
  });

  // Appeler les fonctions au chargement de la page
  document.addEventListener("DOMContentLoaded", () => {
    // Gestion des événements d'ajout au panier
    document.querySelectorAll(".addToCartButton").forEach((button) => {
      button.addEventListener("click", (event) => {
        event.preventDefault();
        handleAddToCartEvent(button, button.getAttribute("data-product-id"));
      });
    });

    // Gestion des événements de suppression du panier
    document.querySelectorAll(".deleteFromCartButton").forEach((button) => {
      button.addEventListener("click", (event) => {
        event.preventDefault();
        handleDeleteFromCartEvent(
          button,
          button.getAttribute("data-product-id")
        );
      });
    });

    // Gestion des événements de suppression du panier
    document.querySelectorAll(".deleteFromCartButton").forEach((button) => {
      button.addEventListener("click", (event) => {
        event.preventDefault();
        handleDeleteFromCartEvent(
          button,
          button.getAttribute("data-product-id")
        );
      });
    });

    // Gestion de l'événement de vidage du panier
    const emptyCartButton = document.getElementById("emptyCartButton");
    if (emptyCartButton) {
      emptyCartButton.addEventListener("click", () =>
        emptyCartEvent(emptyCartButton.getAttribute("data-route"))
      );
    }

    // Gestion de l'événement de suppression d'un article
    const deleteFromCartButtons = document.querySelectorAll(
      ".deleteFromCartButton"
    );
    deleteFromCartButtons.forEach((button) => {
      button.addEventListener("click", (event) => {
        event.preventDefault();
        handleDeleteFromCartEvent(
          button,
          button.getAttribute("data-product-id")
        );
      });
    });

    document.addEventListener("click", function (event) {
      if (event.target.classList.contains("moveToFavoritesButton")) {
        event.preventDefault();

        const productId = event.target.getAttribute("data-product-id");
        const addToFavoriteRoute = event.target.getAttribute("data-add-route");
        const deleteFromCartRoute =
          event.target.getAttribute("data-delete-route");
      }
    });
    // Appeler la fonction au chargement de la page
    window.onload = function () {
      getCartCount();
    };
  });




  // Fonction pour update la quantité sans recharger la page  : 

  let quantityInput = document.getElementById("quantityInput");

  quantityInput.addEventListener("change", function () {
    updateQuantity();
  });

  quantityInput.addEventListener("blur", function () {
    updateQuantity();
  });


async function updateQuantity() {
  // Récupérer la nouvelle quantité
  const quantityInput = document.getElementById("quantityInput");
  const newQuantity = parseInt(quantityInput.value);

  // Vérifier si la nouvelle quantité est valide (supérieure ou égale à zéro)
  if (newQuantity >= 0) {
    // Extraire l'ID du produit à partir de l'URL du formulaire
    const productId = quantityInput.form.action.match(/\/(\d+)$/)[1];

    // Utiliser l'URL d'ajustement de quantité correspondant au produit
    const url = window["adjustQuantityUrl" + productId];

    const formData = new FormData(quantityInput.form);
    formData.set("new_quantity", newQuantity);

    try {
      const response = await fetch(url, {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        throw new Error("Erreur lors de la requête AJAX");
      }

      const data = await response.json();

      // Gérer la réponse JSON 
      console.log(data);

      // Après l'ajustement de la quantité, mettre à jour le nombre d'articles dans le panier et le total du panier
      getCartCount();
      getCartTotal();

      // Mettre à jour le total/produit dans le DOM
      var totalContainer = document.getElementById("totalContainer");
      totalContainer.innerText = data.updatedTotal + " €";
    } catch (error) {
      console.error("Erreur lors de la requête:", error);
    }
  }
}



// Fonction pour changer dynamiquement le prix  total par produit : 



