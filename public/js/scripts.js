console.log("ok");

document.addEventListener("DOMContentLoaded", function () {
  const addToCartButtons = document.querySelectorAll(".addToCartButton");

  addToCartButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      // Récupérer l'ID du produit 
      const productId = button.getAttribute("data-product-id");

      // Appeler la fonction addToCartEvent avec l'ID du produit 

      addToCartEvent(button, productId);
    });
  });
});

function addToCartEvent(button, productId) {
  const flashMessagesContainer = document.getElementById(
    "flashMessagesContainer-" + productId
  );


  const route = button.getAttribute("data-route");

  // Envoyer l'ID du produit comme valeur de "someData"
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



