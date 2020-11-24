<?php

namespace LogementBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use LogementBundle\Entity\Logement;
use LogementBundle\Repository\LogementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LogementController extends Controller
{
    public function newLogementAction(Request $request)
    {
        $logement = new Logement();
        $form = $this->createForm('LogementBundle\Form\LogementType', $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($logement);
            $em->flush();

            return $this->redirectToRoute('_list_logement_admin');
        }

        return $this->render('LogementBundle:Logement:new_logement.html.twig', array(
            'logement' => $logement,
            'form' => $form->createView(),
        ));
    }

    public function pdfAction()
    {
        $em=$this->getDoctrine()->getManager();
        $logements=$em->getRepository(Logement::class)->findAll();
        $html = $this->renderView('LogementBundle:Logement:list_logement_pdf.html.twig', array(
            'logement'  => $logements
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }

    public function searchLogementAction(Request $request)
    {
        $location =   $request->get('location');
        $em=$this->getDoctrine()->getManager();
        if($location == ""){
            $logements=$em->getRepository(Logement::class)->findAll();
        }else{
            $logements=$em->getRepository(Logement::class)->findBy(
                ['adress'=> $location]
            );
        }

        return $this->render('LogementBundle:Logement:list_logement.html.twig', array(
            'logements' => $logements
        ));

    }

    public function editLogementAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $logement = $em->getRepository(Logement::class)->find($id);
        $editForm = $this->createForm('LogementBundle\Form\LogementType', $logement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('_list_logement_admin');
        }

        return $this->render('@Logement/Logement/edit_logement.html.twig', array(
            'logement' => $logement,
            'form' => $editForm->createView(),
        ));
    }

    public function deleteLogementAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $logement=$em->getRepository(Logement::class)->find($id);
        $em->remove($logement);
        $em->flush();
        return $this->redirectToRoute('_list_logement_admin');
    }

    public function listLogementAction()
    {
        $em=$this->getDoctrine()->getManager();
        $logements=$em->getRepository(Logement::class)->getFreeLogement();
        return $this->render('LogementBundle:Logement:list_logement.html.twig', array(
            'logements' => $logements
        ));
    }

    public function ListLogementAdminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $logements=$em->getRepository(Logement::class)->findAll();
        return $this->render('LogementBundle:Logement:list_logement_admin.html.twig', array(
            'logements'=>$logements
        ));
    }

    public function chartsAction()
    {
        $em=$this->getDoctrine()->getManager();
        $usedPlace=$em->getRepository(Logement::class)->getCountUsedPlace();
        $capacities=$em->getRepository(Logement::class)->getCountPlaceFree();
        $capacities=(int)$capacities['number']-(int)$usedPlace['number'];
        $pieChart = new PieChart();



        $pieChart->getData()->setArrayToDataTable( array(
            ['logement', 'Hours per Day'],
            ['capacite',    (int) $capacities],
            ['residents',     (int)$usedPlace['number']],
        ));

        $pieChart->getOptions()->setTitle('Logement chart');
        $pieChart->getOptions()->setHeight(400);
        $pieChart->getOptions()->setWidth(400);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#07600');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(25);


        return $this->render('LogementBundle:Logement:charts.html.twig', array(
                'piechart' => $pieChart,
            )

        );
    }

    public function joinLogementAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $logement=$em->getRepository(Logement::class)->find($id);

        if (in_array($this->getUser(),$logement->getUsers()->toArray())) {
            return $this->render('ManagementServiceBundle:School:affect_user_to_school.html.twig', array(
                "msg"=>"user deja inscrit dans ce logement"

            ));
        }

            $this->getUser()->setLogement($logement);
            $logement->setResident($logement->getResident() +1 );
            $em->flush();
            return $this->redirectToRoute('list_logement');
    }

}
