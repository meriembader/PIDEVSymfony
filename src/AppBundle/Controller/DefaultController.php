<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/listDonArgentb", name="don_list_don_argb")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Don/Don/listDonArgentb.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/addDonProd", name="don_addDonProd")
     */
    public function indexrAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@Don/Don/AddDon.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
