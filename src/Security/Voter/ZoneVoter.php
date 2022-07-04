<?php

namespace App\Security\Voter;

use App\Entity\Zone;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ZoneVoter extends Voter
{
    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
       
       $supportsAttribute = in_array($attribute, ['ZONE_CREATE']);
        $supportsSubject = $subject instanceof Zone;
        return $supportsAttribute && $supportsSubject;
    }
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        // /** ... check if the user is anonymous ... **/
        $user = $token->getUser();
       
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'ZONE_CREATE':
                
                if ($this->CanZone($user)) {
                    return true;
                }  // only admins can create books
                break;
          
        }

        return false;
    }
    private function CanZone($user){
        return in_array("ROLE_GESTIONNAIRE",$user->getRoles());

    }
}