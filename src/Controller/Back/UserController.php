<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\CustomerType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('back/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'back_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('back/user/index.html.twig', [
            'users' => $userRepository->findByRole(),
        ]);
    }

    #[Route('/new', name: 'back_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsBanned(false);
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                '<strong>' . $user->getFirstname() . '</strong> a été ajouté à votre base.'
            );

            return $this->redirectToRoute('back_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'back_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('back/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'back_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        if (!in_array('ROLE_ADMIN', $user->getRoles()) || !in_array('ROLE_MANAGER', $user->getRoles())) {
            $form = $this->createForm(CustomerType::class, $user);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $newPassword = $form->get('password')->getData();
                if ($newPassword) {
                    $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
                }
    
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    '<strong>' . $user->getFirstname() . '</strong> a été modifié dans votre base.'
                );

                return $this->redirectToRoute('back_user_index', [], Response::HTTP_SEE_OTHER);
            }
        } else {
            $form = $this->createForm(UserType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $newPassword = $form->get('password')->getData();
                if ($newPassword) {
                    $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
                }
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    '<strong>' . $user->getFirstname() . '</strong> a été modifié dans votre base.'
                );

                return $this->redirectToRoute('back_user_index', [], Response::HTTP_SEE_OTHER);
            }
        }


        return $this->render('back/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'back_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                '<strong>' . $user->getFirstname() . '</strong> a été supprimer de votre base.'
            );
        }

        return $this->redirectToRoute('back_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
