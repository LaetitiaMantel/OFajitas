console.log("ok");

document.addEventListener("DOMContentLoaded", function () {
  const addToCartButtons = document.querySelectorAll(".addToCartButton");

  addToCartButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      // Récupérer l'ID du produit à partir des attributs de données (data-*)
      const productId = button.getAttribute("data-product-id");
      console.log(productId); // Ajout de cette ligne pour afficher la valeur dans la console JavaScript

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
    body: "someData=" + encodeURIComponent("someValue"),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur lors de la requête AJAX");
      }
      return response.text();
    })
    .then((data) => {
      flashMessagesContainer.innerHTML = data;

      setTimeout(function () {
        flashMessagesContainer.innerHTML = "";
      }, 3000);
    })
    .catch((error) => {
      console.error("Erreur lors de la requête AJAX :", error);
    });
}
