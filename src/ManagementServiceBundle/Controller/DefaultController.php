<?php

namespace ManagementServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ManagementServiceBundle:Default:index.html.twig');
    }
}
