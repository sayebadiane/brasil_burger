<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use phpDocumentor\Reflection\Types\AbstractList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailerController extends AbstractController{
#[Route("/confirme-inscription/{token}", name:"confirm_account")]
public function confirmAccount(string $token,EntityManagerInterface $manager)
    {
        $user = $this->userRepository->findOneBy(["token" => $token]);
        if($user) {
            $user->setToken(null);
            $user->setIsverify(true);
            $manager->persist($user);
            $manager->flush();
        }
    }
}