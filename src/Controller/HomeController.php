<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('home/index.html.twig', [
            // 'products' => $productRepository->findAll() // récupère tous les produits
            'products' => $productRepository->findBy([], ['created_at' => 'DESC', 'id' => 'DESC'], 4) // récupère 4 produits triés par date d'ajout décroissante
            // 'products' => $productRepository->findLast(4) // queryBuilder
            // 'products' => $productRepository->findLastFour() // SQL
        ]);
    }
}
