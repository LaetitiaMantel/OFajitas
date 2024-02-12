<?php
namespace App\Controller\Front;

use App\Repository\BrandRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/marque', name: 'front_brand_')]
class BrandController extends AbstractController
{
    #[Route('/{slug}', name: 'show')]
    public function brandProducts(string $slug, ProductRepository $productRepository, BrandRepository $brandRepository): Response
    {
        // Récupère la marque correspondant au slug
        $brand = $brandRepository->findOneBy(['slug' => $slug]);

        // Récupère les produits par marque
        $products = $productRepository->findByBrand($slug);

        return $this->render('front/product/productList.html.twig', [
            'brand' => $brand,
            'products' => $products,
        ]);
    }
}



