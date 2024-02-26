<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Posts;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('post/new.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
    #[Route('/newpost', name: 'app_newpost')]
    public function new(SluggerInterface $slugger,  Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Posts();
        $user = $this->getUser();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($user);
            if($form->get('img') !== null) {

                $file = $form->get('img')->getData();

                if($file)
                {
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                    $file->move('uploads',  $newFilename);
                    $post->setImage($newFilename);
                }

            }

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_list_car');
        }

        return $this->render('post/new.html.twig', [
            'createPostForm' => $form->createView()
        ]);
    }
}
