console.log("fichier js chargé ");

// Pour ouvrir le champ adresse de facturation si la checkbox facturation est cochée :
const billingCheckbox = document.getElementById(
  "order_useDifferentDeliveryAddress"
);
const billingAddressFields = document.querySelector(".billingAddressFields");

billingCheckbox.addEventListener("change", function () {
  if (this.checked) {
    billingAddressFields.style.display = "block";
  } else {
    billingAddressFields.style.display = "none";
  }

  // Gérer également la visibilité des champs cachés
  const hiddenFields = billingAddressFields.querySelectorAll(
    'input[type="hidden"]'
  );
  hiddenFields.forEach(function (field) {
    field.style.display = this.checked ? "block" : "none";
  });
});
