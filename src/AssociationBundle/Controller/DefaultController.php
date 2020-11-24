<?php

namespace AssociationBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {if ($this->isGranted('ROLE_ADMIN'))
    {
        return $this->render('@Association/Default/index.html.twig');
   }
    else
    {
        return $this->render('@Association/Default/front.html.twig');
    }
    }


}
