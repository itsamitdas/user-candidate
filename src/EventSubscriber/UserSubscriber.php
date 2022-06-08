<?php


namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserSubscriber implements EventSubscriberInterface
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function getSubscribedEvents() : array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if(!$entity instanceof User){
            return;
        }
        $this->createHashPassword($entity);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $user = $args->getObject();
        dd($args);
        if(!$user instanceof User){
            return;
        }
        $this->createHashPassword($user);
    }


    private function createHashPassword(User $user){
        if($user->getPassword()){
            $user->setPassword(
                $this->passwordHasher->hashPassword($user,$user->getPassword())
            );
            $user->eraseCredentials();
        }
    }


}