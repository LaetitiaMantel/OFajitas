<?php
namespace App\DataFixtures\Provider;


class OfajitasProvider{

    // tableau des catégories 
    private $categories = [
        'Bijoux',
        'Pret a porter',
        'Jouet',
        'Décoration',
        'Divers',
    ];

    // tableau des marques
    private $brands = [
        "O'Fajitas",
        "O'K'Ou",
        "O'râge",
        "O'désespoir",
        "O'détresse ennemie",
        "O'lala c'est l'heure de faire dodo",
    ];


     /**
     * Retourne une catégorie au hasard
     */
    public function productCategory()
    {
        return $this->categories[array_rand($this->categories)];
    }

    /**
     * Retourne une marque au hasard
     */
    public function productBrand()
    {
        return $this->brands[array_rand($this->brands)];
    }
}