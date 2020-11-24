<?php

namespace AdminBundle\Controller;

use Mukadi\Chart\Chart;
use Mukadi\Chart\Utils\RandomColorFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Admin/Default/index.html.twig');



    }
    public function someMethod()
    {
        // returns User object or null if not authenticated
        $user = $this->security->getUser();
    }

}
