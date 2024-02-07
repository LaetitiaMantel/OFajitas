<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category/{slug}', name: 'front_categories_show')]
    public function ProductsCategory(string $slug, CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findByCategory($slug);

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoryController',
            'products' => $products,
    ]);
    }
}