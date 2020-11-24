<?php

namespace Projet\ProjBundle\Controller;

use Projet\ProjBundle\Entity\contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Contact controller.
 *
 * @Route("contact")
 */
class contactController extends Controller
{
    /**
     * Lists all contact entities.
     *
     * @Route("/", name="contact_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contacts = $em->getRepository('ProjetProjBundle:contact')->findAll();

        return $this->render('contact/index.html.twig', array(
            'contacts' => $contacts,
        ));
    }

    /**
     * Creates a new contact entity.
     *
     * @Route("/new", name="contact_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm('Projet\ProjBundle\Form\contactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('contact_show', array('id' => $contact->getId()));
        }

        return $this->render('contact/new.html.twig', array(
            'contact' => $contact,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a contact entity.
     *
     * @Route("/{id}", name="contact_show")
     * @Method("GET")
     */
    public function showAction(contact $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);

        return $this->render('contact/show.html.twig', array(
            'contact' => $contact,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing contact entity.
     *
     * @Route("/{id}/edit", name="contact_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, contact $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);
        $editForm = $this->createForm('Projet\ProjBundle\Form\contactType', $contact);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_edit', array('id' => $contact->getId()));
        }

        return $this->render('contact/edit.html.twig', array(
            'contact' => $contact,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a contact entity.
     *
     * @Route("/{id}", name="contact_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, contact $contact)
    {
        $form = $this->createDeleteForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush();
        }

        return $this->redirectToRoute('contact_index');
    }

    /**
     * Creates a form to delete a contact entity.
     *
     * @param contact $contact The contact entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(contact $contact)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contact_delete', array('id' => $contact->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
