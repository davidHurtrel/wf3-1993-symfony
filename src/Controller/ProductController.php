<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig');
    }

    #[Route('/admin/product/create', name: 'product_create')]
    public function create(): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        return $this->render('product/form.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
}
