<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements DataPersisterInterface
{
        private UserPasswordHasherInterface $passwordHasher;
        private EntityManagerInterface $entityManager;
        public function __construct(UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,Mailer $mailer )

        {
                $this->passwordHasher= $passwordHasher;
                $this->entityManager = $entityManager;
                $this->mailer=$mailer;

        }
        public function supports($data): bool
        {
                return $data instanceof User;
        }
        /**
        * @param User $data
        */
        public function persist($data)
        {
                $hashedPassword = $this->passwordHasher->hashPassword(
                $data,
                'passer'
                );
                $data->setPassword($hashedPassword);
                $data->setToken($this->generateToken());
                $data->setExpiredAt(new \DateTime('+2 minutes'));
                $this->entityManager->persist($data);
                $this->entityManager->flush();
                // $this->mailer->setEmail();
                $this->mailer->sendEmail($data->getLogin(), $data->getToken());
                // $this->addFlash("success", "Inscription réussie !");

        }
        public function remove($data)
        {
                $this->entityManager->remove($data);
                $this->entityManager->flush();
        }
        private function generateToken()
        {
                return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        }
}