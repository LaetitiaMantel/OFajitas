<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserTypeUser;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/', name: 'front_user_')]
class UserController extends AbstractController
{   
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

      // route pour afficher les informtions user
      #[Route('/information', name: 'info')]
      public function info() : Response 
      {
            // Récupérer l'utilisateur courant
            $user = $this->getUser();
   
            // on envoie le resultat au twig associé
            return $this->render('front/information/index.html.twig', [
                'user'    => $user,
            ]);
      }

      #[Route('/nouveau', name: 'new', methods: ['GET', 'POST'])]
      public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
      {
          $user = new User();
          $form = $this->createForm(UserTypeUser::class, $user);
          $form->handleRequest($request);
  
          if ($form->isSubmitted() && $form->isValid()) {
              $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
              $user->setRoles(['ROLE_USER']); 
              $entityManager->persist($user);
              try {  
                $entityManager->flush();
                 // Envoi de l'e-mail de confirmation
                $email = (new Email())
                ->from('jonathanaulnette53@gmail.com')
                ->to($user->getEmail())
                ->subject('Confirmation d\'inscription')
                ->html($this->renderView(
                    'email/confirmation.html.twig',
                    ['user' => $user]
                ));
                
                $this->mailer->send($email);
                $this->addFlash(
                    'success',
                    '<strong>' . $user->getFirstname() . '</strong> Vous avez recu un mail de confirmation.'
                );
                } catch (\Throwable $th) {
                    $this->addFlash('warning','Cette adresse mail existe déjà');
                }

              
  
              return $this->redirectToRoute('front_main_home', [], Response::HTTP_SEE_OTHER);
             //TODO voir pour que l utilisateur inscrit soit automatiquement connnecter
         
          }
  
          return $this->render('front/user/new.html.twig', [
              'user' => $user,
              'form' => $form,
          ]);
      }
      
      #[Route('/modifer/{email}', name: 'edit', methods: ['GET', 'POST'])]
      public function edit(Request $request,string $email, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
      {
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

             // Vérifier si l'utilisateur existe
            if (!$user) {
                throw $this->createNotFoundException('Utilisateur non trouvé');
            }

            $form = $this->createForm(UserTypeUser::class, $user);
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
              
                return $this->redirectToRoute('front_user_info', [], Response::HTTP_SEE_OTHER);
            }
          
            return $this->render('front/user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
      }

      #[Route('/supprimer/{email}', name: 'delete', methods: ['POST'])]
      public function delete(Request $request, string $email, EntityManagerInterface $entityManager, 
      TokenStorageInterface $tokenStorage): Response
      {
            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
           
            if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
                $entityManager->remove($user);
                $entityManager->flush();
            }
            // Déconnexion de l'utilisateur après la suppression
            $tokenStorage->setToken(null);
            // invalide la session pour s'assurer que toutes les données de session sont effacées
            $request->getSession()->invalidate(); 
            
             // Envoi de l'e-mail de confirmation
             $email = (new Email())
             ->from('jonathanaulnette53@gmail.com')
             ->to($user->getEmail())
             ->subject('Suppression de votre compte')
             ->html($this->renderView(
                 'email/suppression.html.twig',
                 ['user' => $user]
             ));
             
             $this->mailer->send($email);
            // Envoyer un message flash
            $this->addFlash(
                'success',
                'Votre compte a été supprimé avec succès.'
            );

            return $this->redirectToRoute('front_main_home');
          
      }
}