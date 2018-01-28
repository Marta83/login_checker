<?php

namespace Trovit\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Trovit\Bundle\UserBundle\Command\CheckLoginUseCase;

class UserController extends Controller
{
    public function checkLoginAction(Request $request)
    {
        $username = $request->query->get('username');
        $pass = $request->query->get('pass');

        $redis = $this->container->get('AppBundle\Service\PredisClient');
        $check_login_usecase = new CheckLoginUseCase($redis);
        $response = $check_login_usecase->execute($username, $pass);

        return new JsonResponse($response);
    }
}
