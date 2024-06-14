<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use App\Entity\Posts;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response as BrowserKitResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', 'api_')]
class APIModerateController extends AbstractController
{
    #[Route('/find', name: 'find')]
    public function index(PostsRepository $postsRepository): Response
    {
        return $this->json($postsRepository->findBy(
            ['signaled' => 1, 'moderated' => 0],
        ), 200, [], [
            'groups' => ['posts.index']
        ]);
    }

    #[Route('/validate', name: 'validate')]
    public function validate(PostsRepository $postsRepository, EntityManagerInterface $entityManager, Request $request)
    {
        $postId = $request->query->get('id');

        $post = $postsRepository->find($postId);

        $post->setModerated(1);
        $entityManager->persist($post);
        $entityManager->flush();
        }

    #[Route('/refuse', name: 'refuse')]
    public function refuse(PostsRepository $postsRepository, EntityManagerInterface $entityManager ,Request $request)
    {
        $postId = $request->query->get('id');

        $post = $postsRepository->find($postId);

        $post->setModerated(1);
        $post->setPublished(0);
        $entityManager->persist($post);
        $entityManager->flush();
        }
}