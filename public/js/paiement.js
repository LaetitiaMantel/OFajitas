console.log('Paiement js ok ')


document.addEventListener("DOMContentLoaded", function () {
  const stripe = Stripe(stripePublicKey);
  const elements = stripe.elements();
  const card = elements.create("card");
  card.mount("#card-element");

  const form = document.getElementById("stripePaymentForm");
  const loader = document.getElementById("loader");
  const paymentResult = document.getElementById("payment-result");

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    // Affichez le spinner
     setTimeout(function () {
       loader.style.display = "block";
     }, 500);

    stripe.createToken(card).then(function (result) {
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

  const billingCheckbox = document.getElementById("billingCheckbox");
  const billingAddressFields = document.getElementById("billingAddressFields");

  billingCheckbox.addEventListener("change", function () {
    if (this.checked) {
      billingAddressFields.style.display = "block";
    } else {
      billingAddressFields.style.display = "none";
    }
  });

  const validateUserInfoButton = document.getElementById("validateUserInfo");
  const paymentCard = document.getElementById("paymentCard");

  validateUserInfoButton.addEventListener("click", function () {
    paymentCard.style.display = "block";
  });

  function validateUserInfo() {
    return true;
  }
});
