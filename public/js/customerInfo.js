document.addEventListener("DOMContentLoaded", function () {
    var checkbox = document.querySelector(".billingCheckbox");
    var hiddenForm = document.getElementById("hiddenForm");

  checkbox.addEventListener("change", function () {
    if (checkbox.checked) {
      hiddenForm.style.display = "block"; 
    } else {
      hiddenForm.style.display = "none";
    }
  });
});
