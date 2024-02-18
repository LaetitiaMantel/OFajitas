console.log("fakepayment ok")

console.log("fakepayment ok");
document
  .getElementById("billingCheckbox")
  .addEventListener("click", function () {
    const billingAddressFields = document.getElementById(
      "billingAddressFields"
    );
    console.log("Billing address fields:", billingAddressFields);
    billingAddressFields.style.display = this.checked ? "block" : "none";
  });


document
  .getElementById("validateUserInfo")
  .addEventListener("click", function () {
    // Vérifier si les champs utilisateur sont valides
    if (validateUserInfo()) {
      document.getElementById("paymentCard").style.display = "block"; // Afficher le formulaire de paiement
    } else {
      alert("Veuillez remplir tous les champs utilisateur.");
    }
  });

function validateUserInfo() {
  var firstName = document.getElementById("firstName").value.trim();
  var lastName = document.getElementById("lastName").value.trim();
  // Ajoutez ici d'autres validations si nécessaire

  // Vérifiez si les champs ne sont pas vides
  if (firstName === "" || lastName === "") {
    return false;
  }
  return true;
}

function processPayment() {
  const loader = document.getElementById("loader");
  loader.style.display = "inline-block";

  // Simulation de traitement de paiement
  setTimeout(() => {
    const amount = document.getElementById("amount").value;
    const cardNumber = document.getElementById("card-number").value;
    const expirationDate = document.getElementById("expiration-date").value;
    const cvv = document.getElementById("cvv").value;

    // Affichage des résultats dans la console
    console.log("Montant:", amount);
    console.log("Numéro de carte:", cardNumber);
    console.log("Date d'expiration:", expirationDate);
    console.log("CVV:", cvv);

    // Affichage d'un message de succès
    const paymentResult = document.getElementById("payment-result");
    paymentResult.textContent = "Le paiement a été traité avec succès!";
    paymentResult.classList.remove("hidden");

    loader.style.display = "none";
  }, 2000);
}
