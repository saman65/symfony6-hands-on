<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\MicroPost;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class MicroPostVoter extends Voter
{
    // public const EDIT = 'POST_EDIT'; // We commented these two constnts since wew prefer to define them inside the controller
    // public const VIEW = 'POST_VIEW'; // So we changed the self keywords as well as \App\Entity\ below to MicroPost and added them to MicroPost entity
    public function __construct(
        private Security $security
    ){
    }
    protected function supports(string $attribute, $subject): bool
    { /* Voter gives you two parameters, the $attribute and $subject.
        Typically, the $subject would be a database entity and $attribute an action you want to perform on this entity. */
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [/*self*/ MicroPost::EDIT, /*self*/ MicroPost::VIEW])
            && $subject instanceof /*\App\Entity\*/ MicroPost;
    }

    /**
     * @param MicroPost $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        // if (!$user instanceof UserInterface) { //We accept the anonymous access so we commented this function
        //     return false;
        // }

        $isAuth = $user instanceof UserInterface;
        if($this->security->isGranted('ROLE_ADMIN')){ //This uses the Security component
            return true;
            }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case MicroPost::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                //break; //We commented break because we want everyone to see the posts
                return $isAuth 
                && (
                    $subject->getAuthor()->getId() === $user->getId() ||
                    $this->security->isGranted('ROLE_ADMIN')
                );
            case MicroPost::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                // break; //We commented break because we want everyone to see the posts
                return false; //We added this return since we want everyone to see the micro posts
        }

        return false;
    }
}
