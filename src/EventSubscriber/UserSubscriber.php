<?php

namespace App\EventSubscriber;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Taille;
use App\Entity\Boisson;
use App\Entity\Commande;
use Doctrine\ORM\Events;
use App\Entity\PortionFrite;
use PhpParser\Node\Expr\AssignOp\Mod;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
    $this->token = $tokenStorage->getToken();
    }
    public static function getSubscribedEvents():array{
    return [  Events::prePersist, ];
    }
    private function getUser()
    {
    //dd($this->token);
    if (null === $token = $this->token) {
    return null;
    }
    if (!is_object($user = $token->getUser())) {
    // e.g. anonymous authentication
    return null;
    }
    return $user;
    }
    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getObject() instanceof Burger) {
        $args->getObject()->setGestionnaire($this->getUser());
        }
        else
        if ($args->getObject() instanceof Menu) {
            $args->getObject()->setGestionnaire($this->getUser());
        } 
        else if ($args->getObject() instanceof PortionFrite)
        {
            $args->getObject()->setGestionnaire($this->getUser());
        
        } 
        else if ($args->getObject() instanceof Boisson) {
            $args->getObject()->setGestionnaire($this->getUser());
        } 
        else if($args->getObject() instanceof Commande){
           
          $args->getObject()->setClient($this->getUser()) ;
        }
    }

    public function succesConnexion(AuthenticationSuccessEvent $event){
        $data=$event->getData();
        
        $user=$event->getUser();
        $data['user']=$user->getId();
        $event->setData($data);

    }
    

   
} 
