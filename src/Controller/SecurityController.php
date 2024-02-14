<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    // #[Route(path: '/autologin/{email}/{password}', name: 'autologin')]
    // public function autoLogin(EntityManagerInterface $entityManager, string $email, string $password): Response
    // {
    //     // Recherche de l'utilisateur dans la base de données en fonction de l'email
    //     $userRepository = $entityManager->getRepository(User::class);
    //     $user = $userRepository->findOneBy(['email' => $email]);

    //     // Vérification si l'utilisateur existe et si le mot de passe est correct
    //     if ($user && password_verify($password, $user->getPassword())) {
    //         // Connexion de l'utilisateur (remplacez cette logique par la manière dont vous gérez les connexions dans votre application)
    //         // Exemple: vous pourriez utiliser le composant Security de Symfony pour gérer l'authentification
    //         // Veuillez ajuster cette partie en fonction de votre système d'authentification
    //         // Cette partie suppose que vous utilisez Symfony Security et que vous avez configuré un firewall nommé 'main'
           
    //         // Redirection de l'utilisateur vers une page après connexion réussie
    //         return $this->redirectToRoute('front_main_home');
    //     }

    //     // Si les informations d'identification sont incorrectes, redirigez l'utilisateur vers une page d'erreur ou affichez un message d'erreur
    //     return $this->redirectToRoute('front_main_new');
    // }


    // #[Route(path: '/autologin/{email}/{password}', name: 'autologin')]
    // public function autoLogin(User $user, EntityManagerInterface $entityManager, string $email, string $password):Response
    // {
  
    // // Recherche de l'utilisateur dans la base de données en fonction de l'email
    // $userRepository = $entityManager->getRepository(User::class);
    // $user = $userRepository->findOneBy(['email' => $email]);
    // // Vérification si l'utilisateur existe et si le mot de passe est correct
    // if ('password' == $user->getPassword()) {
        
    //     // Redirection de l'utilisateur vers une page après connexion réussie
    //     //return $this->redirectToRoute('front_main_home');
        
    //     dump($user);
    // }
    // dump($user);
    
    // }   

//     #[Route(path: '/autologin/{email}/{password}', name: 'autologin')]
// public function autoLogin(User $user, EntityManagerInterface $entityManager, string $email, string $password):Response
// {

// // Recherche de l'utilisateur dans la base de données en fonction de l'email
// $userRepository = $entityManager->getRepository(User::class);
// $user = $userRepository->findOneBy(['email' => $email]);

// // Vérification si l'utilisateur existe et si le mot de passe est correct
// if (!$user || !password_verify($password, 'jo')) {
// $this->addFlash('error', 'Identifiants invalides.');
// //dd($user);
// return $this->redirectToRoute('login');
// }

// // Création d'un jeton d'authentification
// //$providerKey = 'secured_area'; // Remplacez par la clé de votre fournisseur
// //token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());

// // Stockage du jeton dans la mémoire de sécurité
// //$this->container->get('security.token_storage')->setToken($token);

// // Redirection vers la page d'accueil
// return $this->redirectToRoute('front_main_home');

// }


   
}
