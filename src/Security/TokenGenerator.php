<?php

namespace App\Security;

class TokenGenerator
{
    private const ALPHABET = "ABCDEFGHIJKLMNOPRSTUWXYZabcdefghijklmnoprstuwxyz0123456789";

    public function getRandomGeneratedToken(int $length = 30):string
    {
        $token = '';
        $maxLength = strlen(self::ALPHABET);

        for($i = 0; $i < $length; $i++){
            $token .= self::ALPHABET[random_int(0, $maxLength -1)];
        }

        return $token;
    }
}