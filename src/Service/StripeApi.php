<?php

namespace App\Service;

use Stripe\Stripe;
use Stripe\Exception\CardException;

class StripeApi
{
    public function __construct(private string $apikey) {}

    public function processPayment(float $amount, string $token): bool
    {
        try {
            // Configuration de la clé secrète de Stripe
            Stripe::setApiKey($this->apikey);

            // Créer une charge avec le token et le montant
            \Stripe\Charge::create([
                'amount' => $amount * 100,  // En cents
                'currency' => 'EUR',
                'source' => $token,
            ]);

            return true;
        } catch (\Stripe\Exception\CardException $e) {
            // Gérer les erreurs liées à la carte
            return false;
        } catch (\Exception $e) {
            // Gérer les autres erreurs
            return false;
        }
    }
}
