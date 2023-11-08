<?php

namespace App\Security;
use DateTime;
use App\Entity\User;
use Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;

Class UserChecker implements UserCheckerInterface{// <- go to definition then copy the two methods of the interface into below
    /**
     * @param User $user
     */
    public function checkPreAuth(UserInterface $user){
        if(null === $user->getBannedUntil()){
            return;
        }
        $now = new DateTime();
        if($now < $user->getBannedUntil()){
            throw new AccessDeniedHttpException('The user is banned');
        }
    }
    /**
     * @param User $user;
     */
    public function checkPostAuth(UserInterface $user){

    }
}// Finally ading user checker to the firewall