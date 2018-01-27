<?php

namespace Trovit\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    public function checkLoginAction(Request $request)
    {
        $redis = $this->container->get('snc_redis.default');
        $val = $redis->set('orugrita','1234');

        $username = $request->query->get('username');
        $pass = $request->query->get('pass');

        $saved_pass = $redis->get($username);

        if(!isset($saved_pass))
        {
          return new JsonResponse(array('success' => false, 'message' => "User does not exist."));
        }

        if($pass != $saved_pass )
        {
          return new JsonResponse(array('success' => false, 'message' => "User and Password do not match."));
        }


        return new JsonResponse(array('success' => true, 'message' => "User and Password match."));
    }
}
