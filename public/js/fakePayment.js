
function processPayment() {
const loader = document.getElementById('loader');
loader.style.display = 'inline-block';

// Simulation de traitement de paiement 
setTimeout(() => {
const amount = document.getElementById('amount').value;
const cardNumber = document.getElementById('card-number').value;
const expirationDate = document.getElementById('expiration-date').value;
const cvv = document.getElementById('cvv').value;

// Affichage des résultats dans la console 
console.log('Montant:', amount);
console.log('Numéro de carte:', cardNumber);
console.log('Date d\'expiration:', expirationDate);
console.log('CVV:', cvv);

// Affichage d'un message de succès 
const paymentResult = document.getElementById('payment-result');
paymentResult.textContent = 'Le paiement a été traité avec succès!';
paymentResult.classList.remove('hidden');

loader.style.display = 'none';
}, 2000); 
}