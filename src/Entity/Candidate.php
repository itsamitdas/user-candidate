<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CandidateToUserController;
use App\Dto\CandidateToUserInputDto;
use App\Repository\CandidateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations:[
        'get',
        'post',
        'candidates/to/user'=>[
            'method' => 'post',
            'path' => 'candidates/to/user',
            'controller' => CandidateToUserController::class,
            'input' => CandidateToUserInputDto::class,
        ]
    ],
    denormalizationContext:['groups'=>["candidate:write"]]
)]
#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("candidate:write")]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("candidate:write")]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups("candidate:write")]
    private $mobile;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups("candidate:write")]
    private $address;

    #[ORM\Column(type: 'boolean')]
    private $isPromoted = 0;

    #[ORM\Column(type: 'string', length: 255)]
    private $cadidateId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function isIsPromoted(): ?bool
    {
        return $this->isPromoted;
    }

    public function setIsPromoted(bool $isPromoted): self
    {
        $this->isPromoted = $isPromoted;

        return $this;
    }

    public function getCadidateId(): ?string
    {
        return $this->cadidateId;
    }

    public function setCadidateId(string $cadidateId): self
    {
        dd($cadidateId);
        $this->cadidateId = $cadidateId;

        return $this;
    }
}
