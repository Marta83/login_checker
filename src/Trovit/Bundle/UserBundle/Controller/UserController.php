<?php

namespace Trovit\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function checkLoginAction(Request $request)
    {
        $username = $request->query->get('username');
        $pass = $request->query->get('pass');

        return new Response();
    }
}
