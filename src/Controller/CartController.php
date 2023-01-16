<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'cart')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    #[Route('/add/{id}', name: 'cart_add')]
    public function add(CartService $cartService, int $id, Request $request): Response
    {
        if ($cartService->add($id) === false) {
            $this->addFlash('danger', 'Il n\'y a pas assez de produits en stock');
        } else {
            $this->addFlash('success', 'L\'article a bien été ajouté au panier');
        }
        if ($request->headers->get('referer') === $this->getParameter('domain') . '/cart/') {
            return $this->redirectToRoute('cart');
        }
        return $this->redirectToRoute('products');
    }

    #[Route('/remove/{id}', name: 'cart_remove')]
    public function remove(CartService $cartService, int $id): Response
    {
        $cartService->remove($id);
        $this->addFlash('success', 'Le produit a bien été supprimé du panier');
        return $this->redirectToRoute('cart');
    }

    #[Route('/delete/{id}', name: 'cart_delete')]
    public function delete(CartService $cartService, int $id): Response
    {
        $cartService->delete($id);
        $this->addFlash('success', 'Le produit a bien été supprimé du panier');
        return $this->redirectToRoute('cart');
    }

    #[Route('/clear', name: 'cart_clear')]
    public function clear(Cartservice $cartService): Response
    {
        $cartService->clear();
        $this->addFlash('success', 'Le panier a bien été vidé');
        return $this->redirectToRoute('cart');
    }
}
