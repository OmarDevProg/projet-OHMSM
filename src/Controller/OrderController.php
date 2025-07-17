<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface; // Import the logger

class OrderController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/place_order', name: 'place_order', methods: ['POST'])]
    public function placeOrder(Request $request, UsersRepository $ur): Response
    {
        $session = $request->getSession();
        if (!$session->has('id')) {
            return $this->json(['success' => false, 'message' => 'You must be logged in to place an order.']);
        }

        $userId = $session->get('id');
        $user = $ur->find($userId);

        if (!$user) {
            return $this->json(['success' => false, 'message' => 'User not found.']);
        }

        $data = json_decode($request->getContent(), true);
        $cartItems = $data['items'] ?? [];
        $subtotal = $data['subtotal'] ?? 0;
        $total = $data['total'] ?? 0;
        $customer = $data['customer'] ?? [];

        if (empty($cartItems)) {
            return $this->json(['success' => false, 'message' => 'The cart is empty.']);
        }

        $order = new Order();
        $order->setUser($user);
        $order->setItems($cartItems);
        $order->setSubtotal($subtotal);
        $order->setTotal($total);
        $order->setCustomer($customer);

        try {
            $this->entityManager->persist($order);
            $this->entityManager->flush();

            return $this->json([
                'success' => true,
                'message' => 'Commande enregistrée avec succès.',
                'redirect' => $this->generateUrl('order_confirmation'),
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement de la commande.',
            ]);
        }
    }


    #[Route('/order_confirmation', name: 'order_confirmation', methods: ['GET'])]
    public function orderConfirmation(Request $request, UsersRepository $ur): Response
    {
        $session = $request->getSession();

        if (!$session->has('id')) {
            return $this->redirectToRoute('home'); // rediriger vers la page de connexion si non connecté
        }

        $userId = $session->get('id');
        $user = $ur->find($userId);

        if (!$user) {
            throw $this->createNotFoundException("Utilisateur non trouvé.");
        }

        // Récupérer les commandes de l'utilisateur
        $orders = $user->getOrders(); // suppose que tu as une relation OneToMany entre User et Order

        return $this->render('orders/confirmation.html.twig', [
            'orders' => $orders,
            'user' => $user,
        ]);
    }

}