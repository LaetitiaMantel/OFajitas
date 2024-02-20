// document.addEventListener("DOMContentLoaded", function () {
//   var stripePublicKey = "{{ stripe_public_key }}";
//   var stripe = Stripe(stripePublicKey);
//   var elements = stripe.elements();

//   var cardElement = elements.create("card");
//   cardElement.mount("#card-element");

//   var form = document.getElementById("stripePaymentForm");

//   form.addEventListener("submit", function (event) {
//     event.preventDefault();

//     stripe
//       .createPaymentMethod({
//         type: "card",
//         card: cardElement,
//       })
//       .then(function (result) {
//         if (result.error) {
//           var errorElement = document.getElementById("card-errors");
//           errorElement.textContent = result.error.message;
//         } else {
//           var paymentMethod = result.paymentMethod.id;
//           var paymentMethodInput = document.createElement("input");
//           paymentMethodInput.type = "hidden";
//           paymentMethodInput.name = "payment_method";
//           paymentMethodInput.value = paymentMethod;
//           form.appendChild(paymentMethodInput);

//           form.submit();
//         }
//       });
//   });
// });

// document
//   .getElementById("billingCheckbox")
//   .addEventListener("click", function () {
//     const billingAddressFields = document.getElementById(
//       "billingAddressFields"
//     );
//     billingAddressFields.style.display = this.checked ? "block" : "none";
//   });

// document
//   .getElementById("validateUserInfo")
//   .addEventListener("click", function () {
//     if (validateUserInfo()) {
//       document.getElementById("paymentCard").style.display = "block";
//     } else {
//       alert("Veuillez remplir tous les champs utilisateur.");
//     }
//   });

// function validateUserInfo() {
//   var firstName = document.getElementById("firstName").value.trim();
//   var lastName = document.getElementById("lastName").value.trim();

//   if (firstName === "" || lastName === "") {
//     return false;
//   }
//   return true;
// }

// function processPayment() {
//   const loader = document.getElementById("loader");
//   loader.style.display = "inline-block";

//   setTimeout(() => {
//     const amount = document.getElementById("amount").value;
//     const cardNumber = document.getElementById("card-number").value;
//     const expirationDate = document.getElementById("expiration-date").value;
//     const cvv = document.getElementById("cvv").value;

//     const paymentResult = document.getElementById("payment-result");
//     paymentResult.textContent = "Le paiement a été traité avec succès!";
//     paymentResult.classList.remove("hidden");

//     loader.style.display = "none";
//   }, 2000);
// }
