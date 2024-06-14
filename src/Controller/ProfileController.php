<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(PostsRepository $PostsRepository): Response
    {
        $user=$this->getUser();
        $listMyPosts = $PostsRepository->findBy(
            ['user' => $user]
        );
        return $this->render('profile/index.html.twig', [
            'user_connected' => $user,
            'listmyposts' => $listMyPosts     
        ]);
    }
}
