<?php 

namespace App\Service;

class FakePaymentService
{
    public function processPayment(float $amount, string $cardNumber): bool
    {
       
        $successCardNumber = "1234";
        $failureCardNumber = "5678";

        if ($cardNumber === $successCardNumber) {
            return true;
        } elseif ($cardNumber === $failureCardNumber) {
            return false;
        }

        // En cas de numéro de carte non reconnu, echec de paiement 
        return false;
    }
}
