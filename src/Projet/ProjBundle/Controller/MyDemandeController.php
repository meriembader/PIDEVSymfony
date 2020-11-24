<?php

namespace Projet\ProjBundle\Controller;

use Projet\ProjBundle\Entity\MyDemande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mydemande controller.
 *
 * @Route("mydemande")
 */
class MyDemandeController extends Controller
{
    /**
     * Lists all myDemande entities.
     *
     * @Route("/", name="mydemande_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $myDemandes = $em->getRepository('ProjetProjBundle:MyDemande')->findAll();

        return $this->render('mydemande/index.html.twig', array(
            'myDemandes' => $myDemandes,
        ));
    }

    /**
     * Creates a new myDemande entity.
     *
     * @Route("/new", name="mydemande_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $myDemande = new Mydemande();
        $form = $this->createForm('Projet\ProjBundle\Form\MyDemandeType', $myDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($myDemande);
            $em->flush();

            return $this->redirectToRoute('mydemande_show', array('id' => $myDemande->getId()));
        }

        return $this->render('mydemande/new.html.twig', array(
            'myDemande' => $myDemande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a myDemande entity.
     *
     * @Route("/{id}", name="mydemande_show")
     * @Method("GET")
     */
    public function showAction(MyDemande $myDemande)
    {
        $deleteForm = $this->createDeleteForm($myDemande);

        return $this->render('mydemande/show.html.twig', array(
            'myDemande' => $myDemande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing myDemande entity.
     *
     * @Route("/{id}/edit", name="mydemande_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MyDemande $myDemande)
    {
        $deleteForm = $this->createDeleteForm($myDemande);
        $editForm = $this->createForm('Projet\ProjBundle\Form\MyDemandeType', $myDemande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mydemande_edit', array('id' => $myDemande->getId()));
        }

        return $this->render('mydemande/edit.html.twig', array(
            'myDemande' => $myDemande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a myDemande entity.
     *
     * @Route("/{id}", name="mydemande_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MyDemande $myDemande)
    {
        $form = $this->createDeleteForm($myDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($myDemande);
            $em->flush();
        }

        return $this->redirectToRoute('mydemande_index');
    }

    /**
     * Creates a form to delete a myDemande entity.
     *
     * @param MyDemande $myDemande The myDemande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MyDemande $myDemande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mydemande_delete', array('id' => $myDemande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
