<?php


namespace App\Service;


use App\Entity\Candidate;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(Private EntityManagerInterface $entityManager, Private UserRepository $userRepository)
    {
    }

    public function createUser(Candidate $candidate): User
    {
        $user = new User();
        $user->setRoles(['ROLE_CLIENT'])
            ->setPassword('123')
            ->setEmail($candidate->getEmail())
            ->setName($candidate->getName())
            ->setMobile($candidate->getMobile())
            ->setAddress($candidate->getAddress());

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

}