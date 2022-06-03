<?php

namespace App\Controller;

use App\Service\LeaveService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeaveManageController extends AbstractController
{
    public function __construct(private LeaveService $leaveService)
    {
    }

    #[Route('/leave/approve/{token}', name: 'app_leave_approve')]
    public function leaveApprove($token): Response
    {
        $leave = $this->leaveService->getLeaveByToken($token);
        if($leave){
            $this->leaveService->leaveApprove($leave);
            $response = [
                "massege" => "Leave approve."
            ];
        }else{
            $response = [
                "massege" => "Invalid request."
            ];
        }
        return $this->render('leave_manage/index.html.twig', ["response" => $response]);
    }

    #[Route('/leave/reject/{token}', name: 'app_leave_reject')]
    public function leaveReject($token): Response
    {
        $leave = $this->leaveService->getLeaveByToken($token);

        if($leave){
            $this->leaveService->leaveReject($leave);
            $response = [
                "massege" => "Leave rejected"
            ];
        }else{
            $response = [
                "massege" => "Invalid request"
            ];
        }
        return $this->render('leave_manage/index.html.twig', ["response" => $response]);
    }
}
