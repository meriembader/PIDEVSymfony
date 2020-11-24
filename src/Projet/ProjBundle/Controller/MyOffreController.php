<?php

namespace Projet\ProjBundle\Controller;

use Projet\ProjBundle\Entity\MyOffre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Myoffre controller.
 *
 * @Route("myoffre")
 */
class MyOffreController extends Controller
{
    /**
     * Lists all myOffre entities.
     *
     * @Route("/", name="myoffre_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $myOffres = $em->getRepository('ProjetProjBundle:MyOffre')->findAll();

        return $this->render('myoffre/index.html.twig', array(
            'myOffres' => $myOffres,
        ));
    }

    /**
     * Creates a new myOffre entity.
     *
     * @Route("/new", name="myoffre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $myOffre = new Myoffre();
        $form = $this->createForm('Projet\ProjBundle\Form\MyOffreType', $myOffre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($myOffre);
            $em->flush();

            return $this->redirectToRoute('myoffre_show', array('id' => $myOffre->getId()));
        }

        return $this->render('myoffre/new.html.twig', array(
            'myOffre' => $myOffre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a myOffre entity.
     *
     * @Route("/{id}", name="myoffre_show")
     * @Method("GET")
     */
    public function showAction(MyOffre $myOffre)
    {
        $deleteForm = $this->createDeleteForm($myOffre);

        return $this->render('myoffre/show.html.twig', array(
            'myOffre' => $myOffre,
            'delete_form' => $deleteForm->createView(),
        ));
    } 

    /**
     * Displays a form to edit an existing myOffre entity.
     *
     * @Route("/{id}/edit", name="myoffre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MyOffre $myOffre)
    {
        $deleteForm = $this->createDeleteForm($myOffre);
        $editForm = $this->createForm('Projet\ProjBundle\Form\MyOffreType', $myOffre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('myoffre_edit', array('id' => $myOffre->getId()));
        }

        return $this->render('myoffre/edit.html.twig', array(
            'myOffre' => $myOffre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a myOffre entity.
     *
     * @Route("/{id}", name="myoffre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MyOffre $myOffre)
    {
        $form = $this->createDeleteForm($myOffre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($myOffre);
            $em->flush();
        }

        return $this->redirectToRoute('myoffre_index');
    }


    /**
     * Creates a form to delete a myOffre entity.
     *
     * @param MyOffre $myOffre The myOffre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MyOffre $myOffre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('myoffre_delete', array('id' => $myOffre->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $myoffre = $em->getRepository(MyOffre::class)->findAll();

        $niveau = $request->get('rech');
        $myoffre = $em->getRepository("ProjetProjBundle:MyOffre")->findBy(array('poste' => $niveau));

        return $this->render("myOffre/index.html.twig", array('myOffres' => $myoffre));
    }
}
