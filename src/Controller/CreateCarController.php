<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CreateCarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CreateCarController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('create_car/index.html.twig', [
            'controller_name' => 'CreateCarController',
        ]);
    }

    #[Route('/createcar', name: 'app_create_car')]
    public function new(Request $request): Response
    {
        $car = new Cars();
        // ...

        $createcarform = $this->createForm(CreateCarType::class, $car);
        $createcarform->handleRequest($request);

        return $this->render('create_car/index.html.twig', [
            'createcarform' => $createcarform->createView()
        ]);
    }
}