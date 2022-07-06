<?php
namespace App\Service\ServicePrix;

use App\Entity\Menu;
use App\Service\ServicePrix\ICalculPrixMenu;

class CalculPrixMenu implements ICalculPrixMenu{
    public function prixMenu(Menu $data): float
    {
        $menuburgers = ($data->getMenuBurgers());
        $prixmenu = 0;
        foreach ($menuburgers  as $menuburger) {
            $prix = $menuburger->getBurger()->getPrix();
            $quantite = $menuburger->getQuantite();
            $prixmenu = $prixmenu + $prix * $quantite;
        }
        $menuportiofrites = $data->getMenuPortionfrites();
        foreach ($menuportiofrites as $key => $menuportiofrite) {
            $prixmenuportion = $menuportiofrite->getPortionfrite()->getPrix();
            $quantite = $menuportiofrite->getQuantity();
            $prixmenu += $prixmenuportion * $quantite;
        }

        $menutailles = $data->getMenuTailles();
        foreach ($menutailles as $key => $menutaille) {
            $prixmenutaille = $menutaille->getTaille()->getPrix();
            $quantite = $menutaille->getQuantity();
            $prixmenu += $prixmenutaille * $quantite;
        }


       
     
        return $prixmenu;
    }

}