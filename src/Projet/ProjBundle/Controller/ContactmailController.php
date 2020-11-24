<?php

namespace Projet\ProjBundle\Controller;

use Projet\ProjBundle\Entity\Contactmail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contactmail controller.
 *
 * @Route("contactmail")
 */
class ContactmailController extends Controller
{
    /**
     * Lists all contactmail entities.
     *
     * @Route("/", name="contactmail_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contactmails = $em->getRepository('ProjetProjBundle:Contactmail')->findAll();

        return $this->render('contactmail/index.html.twig', array(
            'contactmails' => $contactmails,
        ));
    }

    public function sendAction(Request $request)
{
    $contact = new Contactmail();
    $form =$this->createForm('Projet\ProjBundle\Form\ContactmailType', $contact);
    $form->handleRequest($request);
    if($form->isSubmitted()){
        $name=$contact->getName();
        $mail = $contact->getEmail();
        $subject =$contact->getSubject();
        $message = $request->get('form')['message'];
        $username= 'testmaritest123@gmail.com';
        $text = \Swift_Message::newInstance()->setSubject($subject)->setFrom($username)
        ->setTo($mail)->setBody($message);
        $this->get('mailer')->send($text);
        $this->get('session')->getFlashBag('notice','Message envoyé avec succés');

    }
    return $this->render('@ProjetProj/Default/my_email.html.twig' , array('f'=> $form->createView()));

}

    /**
     * Creates a new contactmail entity.
     *
     * @Route("/new", name="contactmail_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $contactmail = new Contactmail();
        $form = $this->createForm('Projet\ProjBundle\Form\ContactmailType', $contactmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactmail);
            $em->flush();

            return $this->redirectToRoute('contactmail_show', array('id' => $contactmail->getId()));
        }

        return $this->render('contactmail/new.html.twig', array(
            'contactmail' => $contactmail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a contactmail entity.
     *
     * @Route("/{id}", name="contactmail_show")
     * @Method("GET")
     */
    public function showAction(Contactmail $contactmail)
    {
        $deleteForm = $this->createDeleteForm($contactmail);

        return $this->render('contactmail/show.html.twig', array(
            'contactmail' => $contactmail,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     *
     * @Route("/mail", name="proj_formail")
     */
    public function msendAction(Request $request)
    {
        $contact = new Contactmail();
        $form = $this->createForm('Projet\ProjBundle\Form\ContactmailType', $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $name = $contact->getName();
            $mail = $contact->getEmail();
            $subject = $contact->getSubject();
            $message = $request->get('form')['message'];
            $username = 'testmaritest123@gmail.com';
            $text = \Swift_Message::newInstance()->setSubject($subject)->setFrom($username)
                ->setTo($mail)->setBody($message);
            $this->get('mailer')->send($text);
            $this->get('session')->getFlashBag('notice', 'Message envoyé avec succés');

        }
        return $this->render('contactmail/mail.html.twig', array('form' => $form->createView(),));

    }
    /**
     * Displays a form to edit an existing contactmail entity.
     *
     * @Route("/{id}/edit", name="contactmail_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Contactmail $contactmail)
    {
        $deleteForm = $this->createDeleteForm($contactmail);
        $editForm = $this->createForm('Projet\ProjBundle\Form\ContactmailType', $contactmail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contactmail_edit', array('id' => $contactmail->getId()));
        }

        return $this->render('contactmail/edit.html.twig', array(
            'contactmail' => $contactmail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a contactmail entity.
     *
     * @Route("/{id}", name="contactmail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Contactmail $contactmail)
    {
        $form = $this->createDeleteForm($contactmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contactmail);
            $em->flush();
        }

        return $this->redirectToRoute('contactmail_index');
    }

    /**
     * Creates a form to delete a contactmail entity.
     *
     * @param Contactmail $contactmail The contactmail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contactmail $contactmail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contactmail_delete', array('id' => $contactmail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
