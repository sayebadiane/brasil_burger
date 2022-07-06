<?php
namespace App\Service\ServicePrix;

use App\Entity\Menu;

interface ICalculPrixMenu{
    public function prixMenu(Menu $menu):float;

}