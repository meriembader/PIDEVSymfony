<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if ($this->isGranted('ROLE_ADMIN'))
        {
            return $this->render('@Don/Don/listDonArgentb.html.twig');
        }
        else
        {
            return $this->render('@Don/Don/AddDon.html.twig');
        }
    }
}
