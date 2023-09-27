<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{#This controlller was created by symfony console make:controller then LoginController. 
# and we have to only set the render part; But we inject AuthenticationUtils as an argument
# to the action to preserve the username after an authentication failure as it is pretty nice for the user
    #[Route('/login', name: 'app_login')]
    public function index(
        AuthenticationUtils $utils
    ): Response
    {
        $lastUsernme = $utils->getLastUsername();
        $error = $utils->getLastAuthenticationError();
        return $this->render('login/index.html.twig', [
            'lastUsername' => $lastUsernme,
            'lastError' => $error
        ]);
    }
    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {

    }
}
