<?php
    namespace App\Email;

use App\Entity\User;
use Swift_Mailer;
use Swift_Message;

class Mailer{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer,\Twig_Environment $twig
    )
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendConfirmation(User $user)
    {
        $body = $this->twig->render('email/confirmation.html.twig',
        [ 
            'user' => $user
        ]);

        $message = (new Swift_Message('API TESTING'))
        ->setFrom("api_blog@api.com")
        ->setTo($user->getEmail())
        ->setBody($body);

        $this->mailer->send($message);
    }
}