<?php

namespace Trovit\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Trovit\Bundle\UserBundle\Entity\Repository\RedisUserRepository;

class UserController extends Controller
{
    public function checkLoginAction(Request $request)
    {
        $redis = $this->container->get('snc_redis.default');
        $val = $redis->set('user:orugrita', serialize(array('username' => 'orugrita', 'password' =>'1234')));

        $username = $request->query->get('username');
        $pass = $request->query->get('pass');

        $redis = $this->container->get('AppBundle\Service\PredisClient');
        $userRepository = new RedisUserRepository($redis);
        $user = $userRepository->loadUserByUsername($username);

        if(!$user)
        {
          return new JsonResponse(array('success' => false, 'message' => "User does not exist."));
        }

        if($pass != $user->getPassword() )
        {
          return new JsonResponse(array('success' => false, 'message' => "User and Password do not match."));
        }


        return new JsonResponse(array('success' => true, 'message' => "User and Password match."));
    }
}
