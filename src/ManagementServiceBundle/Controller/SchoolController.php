<?php

namespace ManagementServiceBundle\Controller;

use ManagementServiceBundle\Entity\School;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class SchoolController extends Controller
{
    public function addSchoolAction(Request $request)
    {

        $school = new School();
        $form = $this->createForm('ManagementServiceBundle\Form\SchoolType', $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($school);
            $em->flush();

            return $this->redirectToRoute('show_schools');
        }

        return $this->render('ManagementServiceBundle:School:add_school.html.twig', array(
            'school' => $school,
            'form' => $form->createView(),
        ));
    }

    public function editSchoolAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $school = $em->getRepository(School::class)->find($id);
        $editForm = $this->createForm('ManagementServiceBundle\Form\SchoolType', $school);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_schools');
        }

        return $this->render('@ManagementService/School/edit_school.html.twig', array(
            'school' => $school,
            'form' => $editForm->createView(),
        ));
    }

    public function showSchoolFrontAction()
    {
        $em=$this->getDoctrine()->getManager();
        $schools=$em->getRepository(School::class)->findAll();
        return $this->render('ManagementServiceBundle:School:show_schools_front.html.twig', array(
            'schools' => $schools
        ));
    }

    public function deleteSchoolAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $school=$em->getRepository(School::class)->find($id);
        $em->remove($school);
        $em->flush();
        return $this->redirectToRoute('show_schools');
    }

    public function showSchoolsAction()
    {
        $em=$this->getDoctrine()->getManager();
        $schools=$em->getRepository(School::class)->findAll();
        return $this->render('ManagementServiceBundle:School:show_schools.html.twig', array(
            'schools' => $schools
        ));
    }

    public function affectUserToSchoolAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $school=$em->getRepository(School::class)->find($id);

        if($school->getNbPlace()>0){
            if (in_array($this->getUser(),$school->getUsers()->toArray())) {
                return $this->render('ManagementServiceBundle:School:affect_user_to_school.html.twig', array(
                "msg"=>"deja inscrit dans cette ecole"
                    ));
            }
            $message = (new \Swift_Message('Claim'))
                ->setFrom('neoxam9@gmail.com')
                ->setTo($school->getEmail())
                ->setBody(
                    "new Student"

                );

            $this->get('mailer')->send($message);
            $this->getUser()->setSchool($school);
            $school->setNbPlace($school->getNbPlace() -1 );
            $em->flush();
            return $this->redirectToRoute('show_user_front');
        }else{
            return $this->render('ManagementServiceBundle:School:affect_user_to_school.html.twig', array(
                "msg"=>"pas de place"

            ));
        }

    }


}
