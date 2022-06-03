<?php

namespace App\Controller;

use App\Service\CandidateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CandidateToUserController extends AbstractController
{
    public function __construct(private CandidateService $candidateService)
    {
    }

    public function __invoke(Request $request)
    {
        $content = json_decode($request->getContent());
        return $this->candidateService->createUsers($content->candidates);
    }


}
