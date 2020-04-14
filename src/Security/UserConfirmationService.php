<?php

namespace App\Security;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserConfirmationService
{   

    private $userRepository;
    private $entityManadger;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManadger)
    {
       $this->entityManadger = $entityManadger;
       $this->userRepository = $userRepository;
    }

    public function confirmUser(string $confirmationToken)
    {
        $user = $this->userRepository->findOneBy(
            ['confirmationToken' => $confirmationToken]
        );

        if(!$user){
            throw new NotFoundHttpException();
        }

        $user->setEnabled(true);
        $user->setConfirmationToken(null);
        $this->entityManadger->flush();
    }
}