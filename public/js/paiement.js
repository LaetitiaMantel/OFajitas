console.log('Paiement js ok ')

// https://docs.stripe.com/js/element 
document.addEventListener("DOMContentLoaded", function () {
  const stripe = Stripe(stripePublicKey);
  const elements = stripe.elements();

  const cardNumberElement = elements.create("cardNumber");
  const cardExpiryElement = elements.create("cardExpiry");
  const cardCvcElement = elements.create("cardCvc");


  cardNumberElement.mount("#cardNumber-element");
  cardExpiryElement.mount("#cardExpiry-element");
  cardCvcElement.mount("#cardCvc-element");


  const form = document.getElementById("stripePaymentForm");
  const loader = document.getElementById("loader");
  const paymentResult = document.getElementById("payment-result");
  //! const payButton = document.getElementById("payButton");

  //! et du coup la j'ai remis type submit psk sinon ça casse le token 
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    // Affichez le spinner
     setTimeout(function () {
       loader.style.display = "block";
     }, 500);

    stripe.createToken(cardNumberElement).then(function (result) {
      // Masquez le spinner en cas d'erreur ou de succès
      loader.style.display = "none";

      if (result.error) {
        alert(result.error.message);
      } else {
        const tokenInput = document.createElement("input");
        tokenInput.setAttribute("type", "hidden");
        tokenInput.setAttribute("name", "stripeToken");
        tokenInput.setAttribute("value", result.token.id);
        form.appendChild(tokenInput);

        // Soumettez le formulaire au serveur
        form.submit();
      }
    });
  });

  
  // // Pour ouvrir le paiement après avoir rempli les information de livraison 
  // const validateUserInfoButton = document.getElementById("validateUserInfo");
  // const paymentCard = document.getElementById("paymentCard");

  // validateUserInfoButton.addEventListener("click", function () {
  //   paymentCard.style.display = "block";
  // });

  // function validateUserInfo() {
  //   return true;
  // }
});
