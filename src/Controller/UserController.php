<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'admin_users')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/adminList.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    #[Route('/admin/user/create', name: 'user_create')]
    public function create(Request $request, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $managerRegistry): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $roles = [];
            $roles[] = $form['roles']->getData();

            $user
                ->setRoles($roles)
                ->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setIsVerified(true);

            $manager = $managerRegistry->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('succes', 'Le nouvel utilisateur a bien été créé');
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('user/form.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    #[Route('/admin/user/delete/{id}', name: 'user_delete')]
    public function delete(User $user, ManagerRegistry $managerRegistry): Response
    {
        $manager = $managerRegistry->getManager();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success', $user->getFirstName() . ' ' . strtoupper($user->getLastName()) . ' a bien été supprimé');
        return $this->redirectToRoute('admin_users');
    }
}
