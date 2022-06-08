<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LeaveRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    denormalizationContext:['groups'=>["leave:write"]],
    normalizationContext: ['groups'=>['leave:read']]
)]
#[ORM\Entity(repositoryClass: LeaveRepository::class)]
#[ORM\Table(name: '`leave`')]
class Leave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('leave:read')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["leave:write", "leave:read"])]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["leave:write", "leave:read"])]
    #[Assert\Choice(['Full-Day','Half-Day'])]
    private $leaveType = "Full-Day";

    #[ORM\Column(type: 'date')]
    #[Groups(["leave:write", "leave:read"])]
    private $fromDate;

    #[ORM\Column(type: 'date')]
    #[Groups(["leave:write", "leave:read"])]
    private $toDate;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Choice(['PENDING','APPROVE','REJECTED'])]
    #[Groups("leave:read")]
    private $status = "PENDING";

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'leaves')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["leave:write", "leave:read"])]
    private $user;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $verifyFromIp;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $remerks;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $token;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLeaveType(): ?string
    {
        return $this->leaveType;
    }

    public function setLeaveType(string $leaveType): self
    {
        $this->leaveType = $leaveType;

        return $this;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->fromDate;
    }

    public function setFromDate(\DateTimeInterface $fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->toDate;
    }

    public function setToDate(\DateTimeInterface $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVerifyFromIp(): ?string
    {
        return $this->verifyFromIp;
    }

    public function setVerifyFromIp(?string $verifyFromIp): self
    {
        $this->verifyFromIp = $verifyFromIp;

        return $this;
    }

    public function getRemerks(): ?string
    {
        return $this->remerks;
    }

    public function setRemerks(?string $remerks): self
    {
        $this->remerks = $remerks;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

}
