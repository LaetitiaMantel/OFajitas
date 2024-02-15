<?php

namespace App\Service;

class FakePaymentService
{
    public function processPayment(int $orderId, int $amount): bool
    {
        // Simulation du paiement
        $isPaymentSuccessful = (bool) rand(0, 1); // Génère aléatoirement true ou false (succès ou échec)

        return $isPaymentSuccessful;
    }
}
