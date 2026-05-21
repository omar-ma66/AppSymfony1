<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BravePizzaController extends AbstractController
{
    #[Route('/brave/pizza', name: 'app_brave_pizza')]
    public function index(): Response
    {
        return $this->render('brave_pizza/index.html.twig', [
            'controller_name' => 'BravePizzaController',
        ]);
    }
}
