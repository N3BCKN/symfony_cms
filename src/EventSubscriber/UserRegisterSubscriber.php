<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use App\Security\TokenGenerator;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Email\Mailer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRegisterSubscriber implements EventSubscriberInterface
{

    private $passwordEncoder;
    private $tokenGenerator;
    private $mailer;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        TokenGenerator $tokenGenerator,
        Mailer $mailer)
    {   
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenGenerator  = $tokenGenerator;
        $this->mailer          = $mailer;
        
        
    }
    public static function getSubscribedEvents()
    {   
        return[
            KernelEvents::VIEW => ['userRegistered', EventPriorities::PRE_WRITE]
        ];
    }

    public function userRegistered(GetResponseForControllerResultEvent $event){
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        
        if(!$user instanceof User || Request::METHOD_POST !== $method){
            return;
        }

        // hash password
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $user->getPassword())
        );

        // generate confirmation token
        $user->setConfirmationToken($this->tokenGenerator->getRandomGeneratedToken());


        //send email with token
        $this->mailer->sendConfirmation($user);

    ;
    }
}
