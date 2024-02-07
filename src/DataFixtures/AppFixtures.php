<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Brand;
use App\Entity\Product;
use App\DataFixtures\Provider\OfajitasProvider;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
             // $manager->persist($product);
        
            // $manager->flush();
    }
}
