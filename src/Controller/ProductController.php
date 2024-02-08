<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit', name: 'front_product_')]
class ProductController extends AbstractController
{
    // route pour afficher tous les produits
    #[Route('/product', name: 'index')]

    public function index(ProductRepository $productRepository,): Response
    {
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }


    // route pour afficher les details d'un produit
    #[Route('/product/{slug}', name: 'show')]


    public function show(string $slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
