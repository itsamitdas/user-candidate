<?php


namespace App\Tests\Service;


use App\Repository\CandidateRepository;
use App\Repository\UserRepository;
use App\Service\CandidateService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CandidateServiceTest extends KernelTestCase
{
    public function testCandidateToUserService()
    {
        $containerData = $this->getContainerData();
        $candidateService = $containerData['candidateService'];
        $candidateRepository = $containerData['candidateRepository'];
        $userRepository = $containerData['userRepository'];

        $notPromotedCandidates = $candidateRepository->findBy(['isPromoted'=>0],[],2,0);
        $notPromotedCandidateIdArray = [];
        if(!empty($notPromotedCandidates)){
            foreach ($notPromotedCandidates as $index=> $notPromotedCandidate){
                $notPromotedCandidateIdArray[$index] = $notPromotedCandidate->getId();
            }
            $result = $candidateService->setCandidatesToUsers($notPromotedCandidateIdArray);

            $promotedCandidate = $candidateRepository->findOneBy(['email' => $result[0]->getEmail()]);
            $user = $userRepository->findOneBy(['email' => $result[0]->getEmail()]);

            $this->assertNotNull($user);
            $this->assertTrue($promotedCandidate->getIsPromoted());

        }else{
            $this->assertEmpty($notPromotedCandidates);
        }
    }

    private function getContainerData()
    {
        self::bootKernel();
        $container = static::getContainer();
        $candidateService = $container->get(CandidateService::class);
        $candidateRepository = $container->get(CandidateRepository::class);
        $userRepository = $container->get(UserRepository::class);

        return [
            "candidateService" => $candidateService,
            "candidateRepository" => $candidateRepository,
            "userRepository" => $userRepository
        ];
    }
}