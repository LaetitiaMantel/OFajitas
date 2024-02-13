console.log("ok");






//  AJOUTER AU PANIER AJAX : 


document.addEventListener("DOMContentLoaded", function () {
  const addToCartButtons = document.querySelectorAll(".addToCartButton");

  addToCartButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      // Récupérer l'ID du produit à partir des attributs de données (data-*)
      const productId = button.getAttribute("data-product-id");

      // Appeler la fonction addToCartEvent avec l'ID du produit
      addToCartEvent(productId);
    });
  });
});

function addToCartEvent(productId) {
  const flashMessagesContainer = document.getElementById(
    "flashMessagesContainer"
  );

  // Récupérer la route de la même manière que dans votre script d'origine
  const addToCartButton = document.querySelector(".addToCartButton");
  const route = addToCartButton.getAttribute("data-route");

  fetch(route.replace("{id}", productId), {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "someData=" + encodeURIComponent(productId),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur lors de la requête AJAX");
      }
      return response.json(); 
    })
    .then((data) => {
      flashMessagesContainer.innerHTML = data.message;

      setTimeout(function () {
        flashMessagesContainer.innerHTML = "";
      }, 3000);
    })
    .catch((error) => {
      console.error("Erreur lors de la requête AJAX :", error);
    });
}



// RETIRER DU PANIER 

document.addEventListener("DOMContentLoaded", function () {
  const deleteFromCartButtons = document.querySelectorAll(".deleteFromCartButton");

  deleteFromCartButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      // Récupérer l'ID du produit 
      const productId = button.getAttribute("data-product-id");

      // Appeler la fonction deleteFromCartEvent avec l'ID du produit 
      deleteFromCartEvent(button, productId);
    });
  });
});

function deleteFromCartEvent(button, productId) {
  const flashMessagesContainer = document.getElementById("flashMessagesContainer-" + productId);
  const route = button.getAttribute("data-route");

  // Envoyer l'ID du produit comme valeur de "someData"
  fetch(route.replace("{id<\\d+>}", productId), {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "someData=" + encodeURIComponent(productId),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur lors de la requête AJAX");
      }
      return response.json(); 
    })
    .then((data) => {
      flashMessagesContainer.innerHTML = data.message;

      // Supprimer visuellement le produit du panier
      const productRow = button.closest("tr");
      if (productRow) {
        productRow.style.opacity = 0;
        setTimeout(function () {
          productRow.remove();
        }, 500);
      }

      setTimeout(function () {
        flashMessagesContainer.innerHTML = "";
      }, 3000);
    })
    .catch((error) => {
      console.error("Erreur lors de la requête AJAX :", error);
    });
}




// Vider le panier : 

function emptyCartEvent(route) {
    const flashMessagesContainer = document.getElementById("flashMessagesContainer");

    // Appeler la fonction emptyCart sur le serveur via AJAX avec la route récupérée
    fetch(route, {
        method: "GET",
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error("Erreur lors de la requête AJAX");
        }
        return response.json();
    })
    .then((data) => {
        flashMessagesContainer.innerHTML = data.message;

        // Supprimer visuellement tous les produits du panier
        const productRows = document.querySelectorAll(".product-row");
        productRows.forEach(function (row) {
            row.remove();
        });

        setTimeout(function () {
            flashMessagesContainer.innerHTML = "";
        }, 3000);
    })
    .catch((error) => {
        console.error("Erreur lors de la requête AJAX :", error);
    });
}

// Ajuster la quantité : 

  public function getTotal(): float
  {
      $session = $this->requestStack->getCurrentRequest()->getSession();
      $cart = $session->get('cart', []);

      $total = 0.0;

      foreach ($cart as $cartItem) {
          $product = $cartItem['product'];
          $quantity = $cartItem['quantity'];
          $total += $product->getPrice() * $quantity; 
      }

      return $total;
  }



