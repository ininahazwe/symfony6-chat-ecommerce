<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService
{
    private MailerInterface $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $templateTwig
     * @param array $context
     * @return void
     * @throws TransportExceptionInterface
     */
    public function send(
        string $to,
        string $subject,
        string $templateTwig,
        array $context
    ): void {
        $email = (new TemplatedEmail())
                ->from(new Address('noreply@ecommece.fr', 'Contact'))
                ->to($to)
                ->subject($subject)
                ->htmlTemplate("mails/$templateTwig")
                ->context($context);
        $this->mailer->send($email);
    }
}
