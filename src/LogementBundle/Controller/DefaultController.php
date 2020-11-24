<?php

namespace LogementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LogementBundle:Default:index.html.twig');
    }
}
