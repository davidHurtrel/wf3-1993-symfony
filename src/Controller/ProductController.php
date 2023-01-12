<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
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
    private $productRepository;

    public function __construct(ManagerRegistry $managerRegistry, ProductRepository $productRepository)
    {
        $this->managerRegistry = $managerRegistry;
        $this->productRepository = $productRepository;
    }

    #[Route('/products', name: 'products')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findBy([], ['name' => 'ASC'])
        ]);
    }

    #[Route('/product/{slug}', name: 'product_show')]
    public function show(ProductRepository $productRepository, string $slug): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $productRepository->findOneBy(['slug' => $slug])
        ]);
    }

    #[Route('/admin/products', name: 'admin_products')]
    public function adminIndex(): Response
    {
        return $this->render('product/adminList.html.twig', [
            'products' => $this->productRepository->findAll()
        ]);
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
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('product/form.html.twig', [
            'productForm' => $form->createView()
        ]);
    }

    #[Route('/admin/product/update/{id}', name: 'product_update')]
    public function update(Product $product, Request $request, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $img1Info = $form['img1']->getData(); // récupère les informations de l'image 1 dans le formulaire
            if ($img1Info !== null) { // s'il y a bien une image dans le formulaire
                $oldImg1Path = $this->getParameter('product_img_dir') . '/' . $product->getImg1(); // récupère le nom de l'ancienne image
                if (file_exists($oldImg1Path)) {
                    unlink($oldImg1Path); // supprime l'ancienne image
                }
                $newImg1Name = time() . '-1.' . $img1Info->guessExtension(); // crée un nom de fichier unique pour l'image 1
                $img1Info->move($this->getParameter('product_img_dir'), $newImg1Name); // télécharge le fichier dans le dossier adéquat
                $product->setImg1($newImg1Name); // définit le nom de l'image à mettre en base de données
            }

            $img2Info = $form['img2']->getData();
            if ($img2Info !== null) {
                $oldImg2Name = $product->getImg2();
                if ($oldImg2Name !== null) {
                    $oldImg2Path = $this->getParameter('product_img_dir') . '/' . $oldImg2Name;
                    if (file_exists($oldImg2Path)) {
                        unlink($oldImg2Path);
                    }
                }
                $newImg2Name = time() . '-2.' . $img2Info->guessExtension();
                $img2Info->move($this->getParameter('product_img_dir'), $newImg2Name);
                $product->setImg2($newImg2Name);
            }

            $img3Info = $form['img3']->getData();
            if ($img3Info !== null) {
                $oldImg3Name = $product->getImg3();
                if ($oldImg3Name !== null) {
                    $oldImg3Path = $this->getParameter('product_img_dir') . '/' . $oldImg3Name;
                    if (file_exists($oldImg3Path)) {
                        unlink($oldImg3Path);
                    }
                }
                $newImg3Name = time() . '-3.' . $img3Info->guessExtension();
                $img3Info->move($this->getParameter('product_img_dir'), $newImg3Name);
                $product->setImg3($newImg3Name);
            }

            $product->setSlug(strtolower($slugger->slug($product->getName())));

            $manager = $this->managerRegistry->getManager();
            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', 'Le produit a bien été modifié');
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('product/form.html.twig', [
            'productForm' => $form->createView()
        ]);
    }

    #[Route('/admin/product/delete/{id}', name: 'product_delete')]
    public function delete(Product $product): Response
    {
        $img1path = $this->getParameter('product_img_dir') . '/' . $product->getImg1();
        if (file_exists($img1path)) {
            unlink($img1path);
        }

        if ($product->getImg2() !== null) {
            $img2path = $this->getParameter('product_img_dir') . '/' . $product->getImg2();
            if (file_exists($img2path)) {
                unlink($img2path);
            }
        }

        if ($product->getImg3() !== null) {
            $img3path = $this->getParameter('product_img_dir') . '/' . $product->getImg3();
            if (file_exists($img3path)) {
                unlink($img3path);
            }
        }

        $manager = $this->managerRegistry->getManager();
        $manager->remove($product);
        $manager->flush();
        
        $this->addFlash('success', 'Le produit a bien été supprimé');
        return $this->redirectToRoute('admin_products');
    }
}
