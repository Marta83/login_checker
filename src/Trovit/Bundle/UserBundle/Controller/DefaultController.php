<?php

namespace Trovit\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TrovitUserBundle:Default:index.html.twig');
    }
}
