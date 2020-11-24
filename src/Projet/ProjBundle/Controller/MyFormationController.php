<?php

namespace Projet\ProjBundle\Controller;

use Projet\ProjBundle\Entity\MyFormation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Myformation controller.
 *
 * @Route("myformation")
 */
class MyFormationController extends Controller
{
    /**
     * Lists all myFormation entities.
     *
     * @Route("/", name="myformation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $myFormations = $em->getRepository('ProjetProjBundle:MyFormation')->findAll();

        return $this->render('myformation/index.html.twig', array(
            'myFormations' => $myFormations,
        ));
    }

    /**
     * Creates a new myFormation entity.
     *
     * @Route("/new", name="myformation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $myFormation = new Myformation();
        $form = $this->createForm('Projet\ProjBundle\Form\MyFormationType', $myFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($myFormation);
            $em->flush();

            return $this->redirectToRoute('myformation_show', array('id' => $myFormation->getId()));
        }

        return $this->render('myformation/new.html.twig', array(
            'myFormation' => $myFormation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a myFormation entity.
     *
     * @Route("/{id}", name="myformation_show")
     * @Method("GET")
     */
    public function showAction(MyFormation $myFormation)
    {
        $deleteForm = $this->createDeleteForm($myFormation);

        return $this->render('myformation/show.html.twig', array(
            'myFormation' => $myFormation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing myFormation entity.
     *
     * @Route("/{id}/edit", name="myformation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MyFormation $myFormation)
    {
        $deleteForm = $this->createDeleteForm($myFormation);
        $editForm = $this->createForm('Projet\ProjBundle\Form\MyFormationType', $myFormation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('myformation_edit', array('id' => $myFormation->getId()));
        }

        return $this->render('myformation/edit.html.twig', array(
            'myFormation' => $myFormation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a myFormation entity.
     *
     * @Route("/{id}", name="myformation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MyFormation $myFormation)
    {
        $form = $this->createDeleteForm($myFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($myFormation);
            $em->flush();
        }

        return $this->redirectToRoute('myformation_index');
    }

    /**
     * Creates a form to delete a myFormation entity.
     *
     * @param MyFormation $myFormation The myFormation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MyFormation $myFormation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('myformation_delete', array('id' => $myFormation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function rechercheAction (Request $request){
        $em=$this->getDoctrine()->getManager();
        $myformation = $em->getRepository(MyFormation::class)->findAll();
        if($request->isMethod("POST")){
            $niveau=$request->get('niveau');
            $myformation=$em->getRepository("ProjetProjBundle:MyFormation")->findBy(array('adresse'=> $niveau));
        }
        return $this->render("myformation/index.html.twig", array('myFormations'=>$myformation));
    }
}
