<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


  class BrandController extends AbstractController
{
    #[Route('/brand/{slug}', name: 'front_brand_show')]
    public function brandProducts(string $slug, ProductRepository $productRepository, BrandRepository $brandRepository): Response
    {
        // récupère les produits par Marques 
        $brands  = $brandRepository->findAll();
        $products = $productRepository->findByBrand($slug);
        

        
        return $this->render('brand/index.html.twig', [
            'controller_name' => 'BrandController',
            'brand' => $slug,
            'brands' => $brands, 
            'products' => $products,

        ]);
    }
}


