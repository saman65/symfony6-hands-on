<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\UserProfileType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsProfileController extends AbstractController
{
    #[Route('/settings/profile', name: 'app_settings_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profile(
        Request $request,
        UserRepository $users
    ): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
/* this specific page would be either for creating the user profile entity or for updating the existing one. 
So we will handle that by getting the user profile of the current user or if it's null. */
        $userProfile = $user->getUserProfile() ?? new UserProfile(); /* ?? evluate the left expression and if it was null then it will do the right one */
        $form = $this->createForm(
            UserProfileType::class, $userProfile
        );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $userProfile = $form->getData();
            $user->setUserProfile($userProfile);
            $users->save($user, true);
            $this->addFlash(
                'success',
                'Your user profile settings were saved'
            );
            return $this->redirectToRoute(
                'app_settings_profile'
            );

        }

        return $this->render('settings_profile/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
