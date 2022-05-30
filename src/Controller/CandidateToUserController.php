<?php

namespace App\Controller;

use App\Service\CandidateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CandidateToUserController extends AbstractController
{
    public function __construct(private CandidateService $candidateService,private SerializerInterface $serializer)
    {
    }

    public function __invoke(Request $request)
    {
        $content = json_decode($request->getContent());
        $result = $this->candidateService->setCandidatesToUsers($content->candidates);
        return $result;
    }


}
