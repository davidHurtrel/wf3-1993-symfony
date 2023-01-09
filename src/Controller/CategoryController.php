<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'categories')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig');
    }

    #[Route('/admin/categories', name: 'admin_categories')]
    public function adminIndex(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/adminList.html.twig', [
            'categories' => $categoryRepository->findAll()
        ]);
    }

    #[Route('/admin/category/create', name: 'category_create')]
    public function create(Request $request, SluggerInterface $slugger, ManagerRegistry $managerRegistry): Response
    {   
        $category = new Category(); // création d'une nouvelle catégorie
        $form = $this->createForm(CategoryType::class, $category); // création d'un formulaire avec en paramètre la nouvelle catégorie
        $form->handleRequest($request); // gestionnaire de requêtes HTTP

        if ($form->isSubmitted() && $form->isValid()) {

            // slug
            $category->setSlug(strtolower($slugger->slug($category->getName())));

            // img
            $infoImg = $form['img']->getData(); // récupère les données du champ img du formulaire
            if (!empty($infoImg)) { // vérifie la présence d'une image dans le formulaire
                $extensionImg = $infoImg->guessExtension(); // récupère l'extension de fichier (le format de l'image)
                $nomImg = time() . '.' . $extensionImg; // crée un nom de fichier unique à partir d'un timestamp
                $category->setImg($nomImg); // définit le nom de l'image à mettre en base de données
                $infoImg->move($this->getParameter('category_img_dir'), $nomImg); // télécharge le fichier dans le dossier adéquat (config/services.yaml)
            }

            $manager = $managerRegistry->getManager(); // récupère le gestionnaire
            $manager->persist($category); // précise au gestionnaire qu'on va vouloir envoyer un objet en base de données (le rend persistant / liste d'attente)
            $manager->flush(); // envoie les objets persistés en base de donnée

            // message de succès

            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('category/create.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }
}
