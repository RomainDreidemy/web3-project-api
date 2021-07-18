<?php


namespace App\Services;


use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private string $from,
        private string $frontPasswordResetUrl,
        private MailerInterface $mailer
    ){}

    public function sendPasswordToken(string $to, string $token): void
    {
        $this->send(
            $to,
            'Bonjour, venez modifier votre mot de passe !',
            "
                <H3>Venez modifier votre mot de passe</H3>
                <p>En cliquant sur le lien ci-dessous vous pourrez modifier votre mot de passe</p>
                <a href='{$this->frontPasswordResetUrl}?token={$token}'>Cliquez ici pour modifier votre mot de passe</a>
            "
        );
    }

    public function sendPasswordRefresh(string $to): void
    {
        $this->send(
            $to,
            'Bonjour, mot de passe modifié !',
            "<H3>Votre mot de passe à bien été modifié.</H3>"
        );
    }

    private function send(string $to, string $subject, string $content): void
    {
        $email = (new Email())
            ->from($this->from)
            ->to($to)
            ->subject($subject)
            ->html($content);

        $this->mailer->send($email);
    }
}