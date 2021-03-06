<?php


namespace App\Service;


use App\Entity\Candidate;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class UserService
{
    public const OFFSET = 0;
    public const LENGTH = 6;

    public function __construct(Private EntityManagerInterface $entityManager, private MailerInterface $mailer)
    {
    }

    public function createUser(Candidate $candidate): User
    {
        $user = new User();
        $plainPassword = $this->createPassword();
        $user->setRoles(['ROLE_EMPLOYEE'])
            ->setPassword($plainPassword)
            ->setEmail($candidate->getEmail())
            ->setName($candidate->getName())
            ->setMobile($candidate->getMobile())
            ->setAddress($candidate->getAddress());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->sendMail($user,$plainPassword);

        return $user;
    }

    private function createPassword(): string
    {
        $charecterSet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = substr(str_shuffle($charecterSet), self::OFFSET, self::LENGTH);
        return $password;
    }

    public function sendMail($user,$plainPassword){

        $email = (new TemplatedEmail())
            ->from("its.amit.das@gmail.com")
            ->to($user->getEmail())
            ->subject("Test for email send")
            ->htmlTemplate("email/user_credential_mail_template.html.twig")
            ->context([
                "user" => $user,
                "plainPassword" => $plainPassword
            ]);

        $this->mailer->send($email);
    }
}