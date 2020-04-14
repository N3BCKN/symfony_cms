<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordAction
{      
    private $validator;
    private $entityManadger;
    private $userPasswordEncoder;
    private $tokenManadger;

    public function __construct(
    ValidatorInterface $validator, 
    UserPasswordEncoderInterface $userPasswordEncoder,
    EntityManagerInterface $entityManadger,
    JWTTokenManagerInterface $tokenManadger
    )
    {
        $this->validator           = $validator;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManadger      = $entityManadger;
        $this->tokenManadger       = $tokenManadger;
        
    }

    public function __invoke(User $data)
    {
        // $reset = new ResetPasswordAction();
        // $reset();
        $this->validator->validate($data);

        $data->setPassword(
            $this->userPasswordEncoder->encodePassword($data, $data->getNewPassword())
        );

        $this->entityManadger->flush();

        $token = $this->tokenManadger->create($data);

        return new JsonResponse(['token' => $token]);
    }
}