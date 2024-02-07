<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


  class BrandController extends AbstractController
{
    #[Route('/brand/{slug}', name: 'brand_products')]
    public function brandProducts(string $slug, ProductRepository $productRepository, BrandRepository $brandRepository): Response
    {
        $products = $productRepository->findByBrand($slug);

        return $this->render('brand/index.html.twig', [
            'controller_name' => 'BrandController',
            'brand' => $slug,
            'products' => $products,
        ]);
    }
}


