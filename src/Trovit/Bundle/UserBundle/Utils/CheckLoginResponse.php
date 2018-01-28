<?php

namespace Trovit\Bundle\UserBundle\Utils;

use Trovit\Bundle\UserBundle\Entity\User;

class CheckLoginResponse
{

    public function getResponse(?User $user, string $pass): array
    {
        $success = $user && $pass == $user->getPassword();
        $message = 'User and Password match.';

        if(!$user){
           $message = "User does not exist.";
        }
        elseif($pass != $user->getPassword() ){
           $message =  "User and Password do not match.";
        }

        return array('success' => $success,
                     'message' => $message);
    }


}

