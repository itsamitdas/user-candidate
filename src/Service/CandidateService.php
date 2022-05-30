<?php


namespace App\Service;

use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class CandidateService
{
    public function __construct(private CandidateRepository $candidateRepository, private UserService $userService, private EntityManagerInterface $entityManager)
    {
    }

    public function setCandidatesToUsers($candidateIds){
        $users = new ArrayCollection();
        foreach ($candidateIds as $candidateId) {
            $user = $this->setCandidateToUser($candidateId);
            if($user){
                $users->add($user);
            }
        }
        return $users;
    }

    private function setCandidateToUser($candidateId){
        $fetchCadidate = $this->candidateRepository->findOneBy(["id"=>$candidateId,'isPromoted'=>0]);
        if(!$fetchCadidate){
            return ;
        }
        if(!$user = $this->userService->createUser($fetchCadidate)){
            return ;
        };

        $fetchCadidate->setIsPromoted(1);
        $this->entityManager->persist($fetchCadidate);
        $this->entityManager->flush();

        return $user;
    }
}