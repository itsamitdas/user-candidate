<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LeaveRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    denormalizationContext:['groups'=>["leave:write"]]
)]
#[ORM\Entity(repositoryClass: LeaveRepository::class)]
#[ORM\Table(name: '`leave`')]
class Leave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("leave:write")]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("leave:write")]
    private $leaveType = "Full-Day";

    #[ORM\Column(type: 'date')]
    #[Groups("leave:write")]
    private $fromDate;

    #[ORM\Column(type: 'date')]
    #[Groups("leave:write")]
    private $toDate;

    #[ORM\Column(type: 'smallint')]
    #[Groups("leave:write")]
    private $status = 0; //0=applied,1=approved,2=rejected

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'leaves')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("leave:write")]
    private $user;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $verifyFromIp;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $remerks;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $verifyToken;


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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
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

    public function getVerifyToken(): ?string
    {
        return $this->verifyToken;
    }

    public function setVerifyToken(?string $verifyToken): self
    {
        $this->verifyToken = $verifyToken;

        return $this;
    }

}
