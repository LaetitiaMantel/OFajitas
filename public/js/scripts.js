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
  const flashMessagesContainer = document.getElementById("flashMessagesContainer-" + productId);
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
  const flashMessagesContainer = document.getElementById("flashMessagesContainer-" + productId);
  const route = button.getAttribute("data-route");

  sendAjaxRequest(
    route.replace("{id<\\d+>}", productId),
    "POST",
    (data) => {
      flashMessagesContainer.innerHTML = data.message;

      const productRow = button.closest("tr");
      if (productRow) {
        productRow.style.opacity = 0;
        setTimeout(() => productRow.remove(), 500);
        getCartCount();
      }

      setTimeout(() => (flashMessagesContainer.innerHTML = ""), 3000);
    },
    (error) => console.error("Erreur lors de la requête AJAX :", error)
  );
}

// Fonction pour vider le panier et mise à jour du compteur
function emptyCartEvent(route) {
  const flashMessagesContainer = document.getElementById("flashMessagesContainer");

  sendAjaxRequest(
    route,
    "GET",
    (data) => {
      flashMessagesContainer.innerHTML = data.message;

      document.querySelectorAll(".product-row").forEach((row) => row.remove());

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
      console.error("Erreur lors de la requête AJAX pour obtenir le nombre d'articles dans le panier :", error)
  );
}

// Événement au chargement de la page
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
      handleDeleteFromCartEvent(button, button.getAttribute("data-product-id"));
    });
  });

  // Gestion de l'événement de vidage du panier
  const emptyCartButton = document.getElementById("emptyCartButton");
  if (emptyCartButton) {
    emptyCartButton.addEventListener("click", () =>
      emptyCartEvent(emptyCartButton.getAttribute("data-route"))
    );
  }
});
// Appeler la fonction au chargement de la page
window.onload = function () {
  getCartCount();
};
