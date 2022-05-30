<?php


namespace App\Dto;


use Symfony\Component\Serializer\Annotation\Groups;

class CandidateToUserInputDto
{
    #[Groups("candidate:write")]
    public array $candidates;
}