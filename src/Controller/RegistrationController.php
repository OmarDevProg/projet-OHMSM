<?php

declare(strict_types=1);

namespace App\Controller;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/verif_log', name: 'verif_log', methods: ['POST'])]
    public function index(
        UsersRepository $UR,
        UserPasswordHasherInterface $passwordHasher,
        Request $request
    ): Response {
        // Retrieve and sanitize input
        $email = strtolower(trim($request->request->get('email')));
        $password = trim($request->request->get('password'));

        // Find the user by email
        $user = $UR->findOneBy(['email' => $email]);

        if (!$user) {
            return $this->redirectToRoute('home', ['showModal' => 'User not found.']);
        }

        // Validate the password
        if (!$passwordHasher->isPasswordValid($user, $password)) {
            return $this->redirectToRoute('home', ['showModal' => 'Invalid password.']);
        }

        // Store session data
        $request->getSession()->set('username', $user->getUsername());
        $request->getSession()->set('id', $user->getId());

        // Redirect with success message
        return $this->redirectToRoute('home', ['showlogged' => 'You are now logged in!']);
    }
    #[Route('/logout', name: 'logout')]
    public function logout(Request $request): Response
    {
        // Supprimer l'utilisateur de la session lors de la déconnexion
        $request->getSession()->remove('username');
        $request->getSession()->remove('id');


        // Rediriger l'utilisateur vers la page d'accueil après la déconnexion
        return $this->redirectToRoute('home');
    }

    // Méthode pour vérifier si l'utilisateur est connecté (facultatif)
    public function isUserLoggedIn(Request $request): bool
    {
        // Vérifier si l'utilisateur est dans la session
        return $request->getSession()->has('username');
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $name = $request->request->get('userName', '');
        $email = strtolower(trim($request->request->get('newEmail', '')));
        $password = $request->request->get('Password', '');
        $confirmPassword = $request->request->get('confirmPassword', '');
        $submittedToken = $request->request->get('_token', '');

        if (!$this->isCsrfTokenValid('register_form', $submittedToken)) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('home');
        }

        if ($password !== $confirmPassword) {
            $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
            return $this->redirectToRoute('home', ['showModal' => 'register']);
        }

        $user = new Users();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword($user, $password));

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Compte créé avec succès !');
        return $this->redirectToRoute('home');
    }


}
