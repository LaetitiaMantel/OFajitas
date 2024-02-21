console.log('paiement')

document.addEventListener("DOMContentLoaded", function () {
  console.log("Stripe Public Key:", stripePublicKey);

   const stripe = Stripe(stripePublicKey);

  const elements = stripe.elements();

  const card = elements.create("card");
  card.mount("#card-element");

  const form = document.getElementById("stripePaymentForm");
  form.addEventListener("submit", function (event) {
    event.preventDefault();

    stripe.createToken(card).then(function (result) {
      if (result.error) {
        alert(result.error.message);
      } else {
        const tokenInput = document.createElement("input");
        tokenInput.setAttribute("type", "hidden");
        tokenInput.setAttribute("name", "stripeToken");
        tokenInput.setAttribute("value", result.token.id);
        form.appendChild(tokenInput);

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