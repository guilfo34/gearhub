<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CarController extends AbstractController
{
    #[Route('/mycars', name: 'app_list_car')]
    public function index(): Response
    {
        return $this->render('car/index.html.twig');
    }

    #[Route('/createacar', name: 'app_create_car')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = new Cars();
        $user = $this->getUser();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $car->setUser($user);


            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_list_car');
        }

        return $this->render('car/new.html.twig', [
            'createcarform' => $form->createView()
        ]);
    }
}