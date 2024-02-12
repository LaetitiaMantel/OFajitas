<?php
namespace App\Controller\Front;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
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

        return $this->render('front/product/productList.html.twig', [
            'products' => $products,
        ]);
    }


    // route pour afficher les details d'un produit
    #[Route('/{slug}', name: 'show')]


    public function show(string $slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        return $this->render('front/product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
