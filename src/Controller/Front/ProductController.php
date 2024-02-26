<?php

namespace App\Controller\Front;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/produit', name: 'front_product_')]
class ProductController extends AbstractController
{
    // route pour afficher tous les produits
    #[Route('/', name: 'index')]
    public function index(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $productsAll = $productRepository->findAll();
        $products = $paginator->paginate(
            $productsAll, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );
        if ($products === null) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }
        return $this->render('front/product/productList.html.twig', [
            'products' => $products,
        ]);
    }
    // route pour afficher les details d'un produit
    #[Route('/{slug}', name: 'show')]
    public function show(string $slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);
        if ($product === null) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }
        return $this->render('front/product/show.html.twig', [
            'product' => $product,
        ]);
    }
    #[Route('/random-products', name: 'random_products')]
    public function getRandomProducts(EntityManagerInterface $entityManager): Response
    {
        $randomProducts = $entityManager->getConnection()
            ->executeQuery('SELECT * FROM product ORDER BY RAND() LIMIT 3') // Changez le nombre selon vos besoins
            ->fetchAllAssociative();
        return $this->render('front/product/randomProducts.html.twig', [
            'products' => $randomProducts,
        ]);
    }
}
