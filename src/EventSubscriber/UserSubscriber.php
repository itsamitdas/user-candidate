<?php


namespace App\EventSubscriber;


use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserSubscriber implements EventSubscriberInterface
{

    public function __construct(private EntityManagerInterface $entityManager, private UserPasswordHasherInterface $passwordHasher)
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

        $this->doPasswordHash($entity);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if(!$entity instanceof User){
            return;
        }

        $this->doPasswordHash($entity);
    }


    private function doPasswordHash(User $user){

        if($user->getPassword()){
            $user->setPassword(
                $this->passwordHasher->hashPassword($user,$user->getPassword())
            );
            $user->eraseCredentials();
        }

    }

}