<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categories', name: 'categories')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig');
    }

    #[Route('/admin/categories', name: 'admin_categories')]
    public function adminIndex(): Response
    {
        return $this->render('categorie/adminList.html.twig');
    }

    #[Route('/admin/category/create', name: 'category_create')]
    public function create(): Response
    {
        $category = new Category(); // création d'une nouvelle catégorie
        $form = $this->createForm(CategoryType::class, $category); // création d'un formulaire avec en paramètre la nouvelle catégorie

        // alimenter la catégorie via un formulaire
        // envoyer en base de données

        return $this->render('categorie/create.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }
}
