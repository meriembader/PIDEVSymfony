<?php

namespace ManagementServiceBundle\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DoctorController extends Controller
{
    public function listAction()
    {
        $user = $this->getUser();
        //if ($user) {

            $em=$this->getDoctrine()->getManager();
            $doctors=$em->getRepository(User::class)->findByrole();
            return $this->render('ManagementServiceBundle:Docteur_Crud:list.html.twig', array(
                'doctors'=>$doctors
            ));
       // }
        //return $this->redirectToRoute('fos_user_security_login');
    }
    public function listFrontAction()
    {
        $user = $this->getUser();
        //if ($user) {

            $em=$this->getDoctrine()->getManager();
            $doctors=$em->getRepository(User::class)->findByrole();
            return $this->render('ManagementServiceBundle:Docteur_Crud:listFront.html.twig', array(
                'doctors'=>$doctors
            ));
       // }
        //return $this->redirectToRoute('fos_user_security_login');
    }
    public function editAction($id,Request $request)
    {
        $userManager= $this->get('fos_user.user_manager');

        $doctor=$userManager->findUserBy(array('id'=>$id));


        $editForm = $this->createForm('UserBundle\Form\RegistrationType', $doctor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $doctor->addRole("ROLE_DOCTOR");

            $userManager->updateUser($doctor);
            $em=$this->getDoctrine()->getManager();
            $doctors=$em->getRepository(User::class)->findByrole();
            return $this->redirectToRoute('doctor_list', array('doctors' => $doctors));
        }

        return $this->render('ManagementServiceBundle:Docteur_Crud:edit.html.twig', array(
            'doctor' => $doctor,
            'form' => $editForm->createView(),
            'id' => $id
        ));

    }
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $doctor=$em->getRepository(User::class)->find($id);
        $em->remove($doctor);
        $em->flush();
            return $this->redirectToRoute('doctor_list');
    }
    public function pdfAction()
    {
        $em=$this->getDoctrine()->getManager();
        $doctors=$em->getRepository(User::class)->findByrole();
        $html = $this->renderView('@ManagementService/Docteur_Crud/pdf.html.twig', array(
            'doctors'  => $doctors
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }

    public function searchByStatutAction($status)
    {
        $em=$this->getDoctrine()->getManager();
        if($status == 'all'){
            $doctors=$em->getRepository(User::class)->findByrole();
        }else{
            $doctors=$em->getRepository(User::class)->findBy([
                'statut' => $status
            ]);
        }

        return $this->render('ManagementServiceBundle:Docteur_Crud:list.html.twig', array(
            'doctors'=>$doctors
        ));
    }
}
