<?php

namespace Projet\ProjBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{

    public function addAction()
    {
        return $this->render('home_user.html.twig', array(
            // ...
        ));
    }


    public function redirectAction()
    {
        $authChecker = $this->container->get('security.authorization_checker');

        if($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->render('@ProjetProj/Security/home_admin.html.twig');
        } else if ($authChecker->isGranted('ROLE_USER')) {
            return $this->render('@ProjetProj/Security/home_user.html.twig');
        } else {
            return $this->render('@FOSUser/Security/login.html.twig');
        }

    }

}
