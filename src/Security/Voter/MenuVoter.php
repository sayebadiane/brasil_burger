<?php

namespace App\Security\Voter;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Gestionnaire;
use Symfony\Component\Security\Core\Security;
use Container9LgJWl7\getGestionnaireRepositoryService;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class MenuVoter extends Voter
{
    
    // public const post_menu = 'POST_EDIT';
    // public const get_menu = 'POST_VIEW';


    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $menu): bool
    {
        if($attribute==="MENU_ALL"){
            $menu=new $menu();
            //dd($menu);

        }
        $tableau = in_array($attribute, ["AJOUTER_MENU","DETAIL_MENU","MENU_ALL"]);
      
        $menus = $menu instanceof \App\Entity\Menu;
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
       
       return $tableau && $menus ;
    }

    protected function voteOnAttribute(string $attribute, $menu, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        //on verifie si  l' utilisateur qui ajoute le menu
        // if(null===$menu->getGestionnaire())
        //     return false;

        


        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {

            case "AJOUTER_MENU":
                // logic to determine if the user can EDIT
                // return true or false
                if($this->canEdit($user)){
                    return true;
                }
                break;
            case "DETAIL_MENU" :
                if ($this->canEdit($user)) {
                    return true;
                }
                break;
            case "MENU_ALL":
              
                if ($this->canEdit($user)) {
                    return true;
                }
                break;
        }

        return false;
    }
    private function canEdit(User $user){
     return in_array("ROLE_GESTIONNAIRE",$user->getRoles());
    }
}
