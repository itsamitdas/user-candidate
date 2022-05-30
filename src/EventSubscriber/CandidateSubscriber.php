<?php


namespace App\EventSubscriber;


use App\Entity\Candidate;
use App\Repository\CandidateRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;


class CandidateSubscriber implements EventSubscriberInterface
{
    public function __construct(private CandidateRepository $repository)
    {
    }

    public function getSubscribedEvents() : array
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $candidate = $args->getObject();

        if(!$candidate instanceof Candidate){
            return;
        }

        $candidateId = $this->createUniqueCandidateId($candidate->getName());
        $candidate->setCadidateId($candidateId);

    }

    private function createUniqueCandidateId($name): string
    {
        $cadidateId = $this->getCanditureId($name);
        $candidate = $this->repository->findOneBy(['cadidateId' =>  $cadidateId]);
        if ($candidate) {
            $this->createCandidateId($name);
        }

        return $cadidateId;
    }

    private function getCanditureId($name): string
    {
        $prefix = "EPL";

        $explodedName = explode(" ",$name);
        if(sizeof($explodedName)>1){
            $lastname = end($explodedName);
            $shortName = $explodedName[0][0].$lastname[0];
        }else{
            $shortName = $explodedName[0][0];
        }

        $randomNumber = rand(1000,9999);

        $createdCandidateId = strtoupper($prefix.$shortName.$randomNumber);
        return $createdCandidateId;
    }

}