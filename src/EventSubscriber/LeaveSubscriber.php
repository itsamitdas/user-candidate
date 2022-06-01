<?php


namespace App\EventSubscriber;


use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use App\Entity\Leave;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;


class LeaveSubscriber implements EventSubscriberInterface
{

    public function __construct(private MailerInterface $mailer)
    {
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
        ];
    }


    public function postPersist(LifecycleEventArgs $args): void
    {
        $leave = $args->getObject();
        if(!$leave instanceof Leave){
            return;
        }
        $this->sendMail($leave);
    }

    private function sendMail(Leave $leave){
        dump($leave->getUser()->getName());
        $email = (new TemplatedEmail())
            ->from($leave->getUser()->getEmail())
            ->to("hr@einzigtech.com")
            ->subject("Test for email send")
            ->htmlTemplate("email/leaveApplication.html.twig")
            ->context([
                "leave" => $leave,
            ]);

        $this->mailer->send($email);
    }}