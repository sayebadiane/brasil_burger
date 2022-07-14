<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Commande;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CommandeVoter extends Voter
{
    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $commande): bool
    {
        $supportsAttribute = in_array($attribute, ['COMMANDE_CREATE', 'COMMANDE_READ', 'COMMANDE_EDIT', 'COMMANDE_DELETE']);
        $supportsSubject = $commande instanceof Commande;

        return $supportsAttribute && $supportsSubject;
    }

    /**
     * @param string $attribute
     * @param Commande $commande
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $commande, TokenInterface $token): bool
    {
        /** ... check if the user is anonymous ... **/
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'COMMANDE_CREATE':
                if ($this->canAjouter($user)) {
                    return true;
                }  // only admins can create books
                break;
                /** ... other autorization rules ... **/
        }

        return false;

    }
    private function canAjouter(User $user)
    {
        return in_array('ROLE_GESTIONNAIRE',$user->getRoles());
    }
}