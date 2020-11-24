<?php

namespace LogementBundle\Controller;

use LogementBundle\Entity\FamilleAceuill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FamilleController extends Controller
{
    public function newAction(Request $request)
    {
        $famille = new FamilleAceuill();
        $form = $this->createForm('LogementBundle\Form\FamilleAceuillType', $famille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($famille);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('LogementBundle:Famille:new.html.twig', array(
            'logement' => $famille,
            'form' => $form->createView(),
        ));
    }

    public function sendEmailAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $famille=$em->getRepository(FamilleAceuill::class)->find($id);
        $message = (new \Swift_Message('Claim'))
            ->setFrom('neoxam9@gmail.com')
            ->setTo($famille->getEmail())
            ->setBody(
                "logement"

            );

        $this->get('mailer')->send($message);
        return $this->redirectToRoute('list');
    }

    public function listAction()
    {
        $em=$this->getDoctrine()->getManager();
        $logements=$em->getRepository(FamilleAceuill::class)->findAll();

        return $this->render('LogementBundle:Famille:list.html.twig', array(
            'logements' => $logements
        ));
    }

}
