<?php 

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface ProtectedRoutesInterface
{
    public function setAuthor(UserInterface $user): ProtectedRoutesInterface;
}