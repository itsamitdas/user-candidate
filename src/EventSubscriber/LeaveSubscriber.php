<?php


namespace App\EventSubscriber;


use App\Repository\LeaveRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use App\Entity\Leave;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;


class LeaveSubscriber implements EventSubscriberInterface
{
    public const OFFSET = 0;
    public const LENGTH = 6;

    public function __construct(private MailerInterface $mailer, private LeaveRepository $leaveRepository)
    {
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::postPersist,
        ];
    }


    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if(!$entity instanceof Leave){
            return;
        }

        $this->setToken($entity);
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $leave = $args->getObject();
        if(!$leave instanceof Leave){
            return;
        }
        $this->sendMail($leave);
    }

    private function setToken(Leave $leave): Leave
    {
        $token = $this->createUniqueToken();
        return $leave->setToken($token);
    }

    private function createUniqueToken(): string
    {
        $charecterSet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = md5(substr(str_shuffle($charecterSet), self::OFFSET, self::LENGTH));

        $leave = $this->leaveRepository->findOneBy(['token' =>  $token]);
        if ($leave) {
            $this->createUniqueToken();
        }

        return $token;
    }

    private function sendMail(Leave $leave){
        $email = (new TemplatedEmail())
            ->from($leave->getUser()->getEmail())
            ->to("hr@einzigtech.com")
            ->subject("Test for email send")
            ->htmlTemplate("email/leave_application_mail_template.html.twig")
            ->context([
                "leave" => $leave,
                "token" => $leave->getToken()
            ]);

        $this->mailer->send($email);
    }
}