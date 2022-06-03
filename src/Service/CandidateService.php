<?php


namespace App\Service;

use App\Entity\Candidate;
use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class CandidateService
{
    public function __construct(private CandidateRepository $candidateRepository, private UserService $userService, private EntityManagerInterface $entityManager)
    {
    }

    public function createUsers($candidateIds){
        $users = new ArrayCollection();
        foreach ($candidateIds as $candidateId) {
            $user = $this->setCandidateToUser($candidateId);
            if($user){
                $users->add($user);
            }
        }
        return $users;
    }

    private function setCandidateToUser($id){

        $candidate = $this->fetchNonPromotedCandidateById($id);
        if (!$candidate){
            return ;
        }
        $user = $this->userService->createUser($candidate);
        $this->updateCandidatePromotedStatus($candidate);
        return $user;
    }

    private function fetchNonPromotedCandidateById($id): ?Candidate
    {
        return $this->candidateRepository->findOneBy(["id"=>$id,'isPromoted'=>0]);
    }

    private function updateCandidatePromotedStatus(Candidate $candidate): Candidate
    {
        $candidate->setIsPromoted(1);
        $this->entityManager->persist($candidate);
        $this->entityManager->flush();

        return $candidate;
    }
}