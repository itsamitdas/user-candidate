<?php


namespace App\Service;


use App\Entity\Leave;
use App\Repository\LeaveRepository;
use Doctrine\ORM\EntityManagerInterface;

class LeaveService
{
    public function __construct(private LeaveRepository $leaveRepository, private EntityManagerInterface $entityManager)
    {

    }

    public function getLeaveByToken(string $token): ?Leave
    {
        return $this->leaveRepository->findOneby(['token' => $token]);
    }

    public function leaveApprove(Leave $leave): Leave
    {
        $leave->setStatus(1)
            ->setRemerks("Approved")
            ->setVerifyFromIp($_SERVER['HTTP_USER_AGENT'])
            ->setToken("");

        $this->entityManager->persist($leave);
        $this->entityManager->flush();

        return $leave;
    }


    public function leaveReject(Leave $leave): Leave
    {
        $leave->setStatus(2)
            ->setRemerks("Rejected")
            ->setVerifyFromIp($_SERVER['HTTP_USER_AGENT'])
            ->setToken("");

        $this->entityManager->persist($leave);
        $this->entityManager->flush();

        return $leave;
    }

}