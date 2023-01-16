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

    public function add(int $id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []); // récupère le panier ou un tableau vide
        $stock = $this->productRepository->find($id)->getQuantity(); // récupère le stock en base de données
        if (!empty($cart[$id])) { // si le produit est déjà dans le panier
            if ($cart[$id] >= $stock) { // s'il n'y a pas assez de produits en stock
                return false;
            } else {
                $cart[$id]++; // incrémente de 1 la quantité associée
            }
        } else {
            if ($stock > 0) { // s'il y a un moins 1 produit en stock
                $cart[$id] = 1; // définit la quantité associée à 1
            } else {
                return false;
            }
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function remove(int $id): void
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function delete(int $id): void
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function clear(): void
    {
        $this->requestStack->getSession()->remove('cart');
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

    public function getTotal(): float
    {
        $cart = $this->getCart();
        $total = 0;
        foreach ($cart as $element) {
            $product = $element['product'];
            $total += $product->getPrice() * $element['quantity'];
        }
        // OU
        //
        // $cart = $this->requestStack->getSession()->get('cart', []);
        // $total = 0;
        // foreach ($cart as $id => $quantity) {
        //     $product = $this->productRepository->find($id);
        //     $total += $product->getPrice() * $quantity;
        // }
        return $total;
    }
}
