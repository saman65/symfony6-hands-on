<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    #[Route('/like/{id}', name: 'app_like')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function like(MicroPost $post, MicroPostRepository $posts, Request $request): Response
    {
        $currentUser = $this->getUser();
        $post->addLikeBy($currentUser);
        $posts->save($post, true);

        return $this->redirect($request->headers->get('referer'));//This return redirects to the last page using Request and its referer method
    }
    #[Route('/unlike/{id}', name: 'app_unlike')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function unlike(MicroPost $post, MicroPostRepository $posts, Request $request): Response
    {
        $currentUser = $this->getUser();
        $post->removeLikeBy($currentUser);
        $posts->save($post, true);

        return $this->redirect($request->headers->get('referer'));
    }
}
