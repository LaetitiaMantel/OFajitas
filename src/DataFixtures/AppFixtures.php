<?php

namespace App\DataFixtures;

use App\DataFixtures\Provider\OfajitasProvider;
use Faker\Factory;
use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{

    public function __construct(private SluggerInterface $slugger) {
    }
    // tableau des catégories 
    private $categories = [];

    // tableau des marques
    private $brands = [];

    // tableau du home order
    private $homeOrder = [1, 2, 3, 4, 5];

    public function load(ObjectManager $manager): void
    {
       

        $faker = Factory::create('fr_FR');
        $faker->addProvider(new OfajitasProvider);

        // création de 6 marques
        for ($i = 0; $i<6; $i++){
            $brand = new Brand;
            $brand->setName($faker->unique()->productBrand());
            $brand->setSlug($this->slugger->slug($brand->getName())->lower());
            $brand->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $brand->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $manager->persist($brand);
            $this->brands[] = $brand;
        }

        //création de 5 catégories
        for ($i = 0; $i<5; $i++){
            $category = new Category;
            $category->setName($faker->unique()->productCategory());
            $category->setSlug($this->slugger->slug($category->getName())->lower());
            // tableau du home order
            $homeOrder = [1, 2, 3, 4, 5];
            shuffle($homeOrder);
            $category->setHomeOrder($homeOrder[1]);
            $category->setPicture($faker->imageUrl(360, 360, 'category'));
            $category->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $category->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $manager->persist($category);
            $this->categories[] = $category;
        }

        //création de 100 produits
        for ($i=0; $i<100; $i++) {
            $product = new Product();
            $product->setName($faker->word());
            $product->setDescription($faker->paragraph());
            $product->setPicture($faker->imageUrl(360, 360, 'fajitas'));
            $product->setPrice($faker->numberBetween(1000, 10000));
            $product->setRating($faker->randomFloat(1, 0, 5));
            $product->setStatus($faker->boolean());
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setBrand($faker->randomElement($this->brands));
            $product->setCategory($faker->randomElement($this->categories));
            $product->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));
            $product->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisDecade()));

            $manager->persist($product);
        }
        $manager->flush();
    }
}
