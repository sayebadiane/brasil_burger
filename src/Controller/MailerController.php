<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController
{
    #[Route("/confirme-inscription/{token}", name: "confirm_account")]
    public function confirmAccount(string $token,ClientRepository $client, EntityManagerInterface $manager)
    {
        $user = $client->findOneBy(["token" => $token]);
        if ($user) {
            $user->setToken(null);
            $user->setIsverify(true);
            $manager->persist($user);
            $manager->flush();
            return $this->json(["succes"=>"votre compte a été activer"]);
        }
        else{
            return $this->json(["error" => "votre  n'a pas a été activer"]);


        }
    }
   
}
