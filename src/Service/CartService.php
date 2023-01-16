<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    protected $requestStack;
    protected $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }

    public function add(int $id): void
    {
        $cart = $this->requestStack->getSession()->get('cart', []); // récupère le panier ou un tableau vide
        if (!empty($cart[$id])) { // si le produit est déjà dans le panier
            $cart[$id]++; // incrémente de 1 la quantité associée
        } else {
            $cart[$id] = 1; // définit la quantité associée à 1
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function remove()
    {
        
    }

    public function delete()
    {
        
    }

    public function clear()
    {
        
    }

    public function getCart(): array
    {
        $sessionCart = $this->requestStack->getSession()->get('cart', []); // récupère le panier en session
        $cart = []; // initialise un nouveau panier
        foreach ($sessionCart as $id => $quantity) {
            $element = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
            $cart[] = $element;
        }
        return $cart;
    }
}
