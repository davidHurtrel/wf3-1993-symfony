<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/product', name: 'product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig');
    }

    #[Route('/admin/product/create', name: 'product_create')]
    public function create(Request $request, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $infoImg1 = $form['img1']->getData();

            if (empty($infoImg1)) {
                $this->addFlash('danger', 'Le produit n\'a pas pu être créé : l\'image principale est obligatoire mais n\'a pas été renseignée.');
                return $this->redirectToRoute('product_create');
            } elseif (empty($form['alt1']->getData())) {
                $this->addFlash('danger', 'Le texte alternatif pour l\'image pricnipale est obligatoire.');
                return $this->redirectToRoute('product_create');
            }

            $img1Name = time() . '-1.' . $infoImg1->guessExtension();
            $infoImg1->move($this->getParameter('product_img_dir'), $img1Name);
            $product->setImg1($img1Name);

            $infoImg2 = $form['img2']->getData();
            if (!empty($infoImg2)) {
                $img2Name = time() . '-2.' . $infoImg2->guessExtension();
                $infoImg2->move($this->getParameter('product_img_dir'), $img2Name);
                $product->setImg2($img2Name);
            }

            $infoImg3 = $form['img3']->getData();
            if (!empty($infoImg3)) {
                $img3Name = time() . '-3.' . $infoImg3->guessExtension();
                $infoImg3->move($this->getParameter('product_img_dir'), $img3Name);
                $product->setImg3($img3Name);
            }

            $product->setSlug(strtolower($slugger->slug($product->getName())));
            $product->setCreatedAt(new \DateTimeImmutable());

            $manager = $this->managerRegistry->getManager();
            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', 'Le produit a bien été créé');
            throw new Exception('À faire : rediriger vers la liste des produits de l\'espace admin');
            // return $this->redirectToRoute('product_create');
        }

        return $this->render('product/form.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
}
