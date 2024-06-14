<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Repository\PostsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UserRepository $userRepository, PostsRepository $postsRepository): Response
    {

        $listUser = $userRepository->findAll();
        $listPosts = $postsRepository->findBy(
            ['published' => true,
            ]
        );
        
        return $this->render('home/index.html.twig', [
            'listUser' => count($listUser),
            'listposts' => $listPosts
        ]);
    }

    #[Route(path: '/signal/{post}', name: 'app_signal')]
    public function signal(Posts $post , EntityManagerInterface $entityManager): Response
    {

        $post->setSignaled(1);
        
        $entityManager->persist($post);
        $entityManager->flush();
        
        return $this->redirectToRoute("app_home");
    }
    
}
