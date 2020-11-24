<?php

namespace AssociationBundle\Controller;
use AssociationBundle\Entity\Association;
use AssociationBundle\Repository\AssociationRepository;
use Doctrine\DBAL\Types\TextType;

use PDO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mukadi\Chart\Utils\RandomColorFactory;
use Mukadi\Chart\Chart;
use Mukadi\ChartJSBundle\Chart\NativeBuilder;
use Mukadi\Chart\Builder;



/**
 * Association controller.
 *
 */
class AssociationController extends Controller
{


    /**
     * Lists all association entities.
     *
     */

    public function indexAction( Request $request)
    {
      $em = $this->getDoctrine()->getManager();
        $listAssociations = $em->getRepository('AssociationBundle:Association')->findAll();

        $associations  = $this->get('knp_paginator')->paginate(
            $listAssociations,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            4/*nbre d'éléments par page*/


        );
        return $this->render('association/index.html.twig', array(
            'associations' => $associations,
        ));

    }

    /**
     * Creates a new association entity.
     *
     */
    public function newAction(Request $request)
    {
        $association = new Association();
        $form = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($association);
            $em->flush();

            return $this->redirectToRoute('association_show', array('id' => $association->getId()));
        }

        return $this->render('association/new.html.twig', array(
            'association' => $association,
            'form' => $form->createView(),

        ));

    }

    /**
     * Finds and displays a association entity.
     *
     */
    public function showAction(Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);

        return $this->render('association/show.html.twig', array(
            'association' => $association,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing association entity.
     *
     */
    public function editAction(Request $request, Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);
        $editForm = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('association_edit', array('id' => $association->getId()));
        }

        return $this->render('association/edit.html.twig', array(
            'association' => $association,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a association entity.
     *
     */
    public function deleteAction(Request $request, Association $association)
    {
        $form = $this->createDeleteForm($association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($association);
            $em->flush();
        }

        return $this->redirectToRoute('association_index');
    }

    /**
     * Creates a form to delete a association entity.
     *
     * @param Association $association The association entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Association $association)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('association_delete', array('id' => $association->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


   /* public function listAexcel()
    {



*/
   /* public function listA()
    {
        var_dump('1').die();

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $em = $this->getDoctrine()->getManager();

        $associations = $em->getRepository('AssociationBundle:Association')->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('association/listB.twig', array(
            'associations' => $associations,
        ));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true


        ]);

    }*/
    /**
     * pdf a association entity.
     *
     */
    public function pdfAction()
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $em = $this->getDoctrine()->getManager();

        $associations = $em->getRepository('AssociationBundle:Association')->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('association/listA.html.twig', array(
            'associations' => $associations,
        ));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true


        ]);

    }

    /**
     * excel a association entity.
     *
     */
    public function ExcelAction()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1','raisonSociale');
        $sheet->setCellValue( 'C1','raisonSociale');
        $sheet->setCellValue( 'D1','telephone ');
        $sheet->setCellValue( 'E1','domaine ');
        $sheet->setCellValue('F1','gouvernorat ');
        $sheet->setTitle("Liste des associations");

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        // Create a Temporary file in the system
        $fileName = 'ExcelFile.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $em = $this->getDoctrine()->getManager();

        $associations = $em->getRepository('AssociationBundle:Association')->findAll();

        $html = $this->renderView('association/listAexcel.html.twig', array(
            'associations' => $associations,
        ));

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }



    public function chartAction() {
        $connection = new PDO('mysql:dbname=pi;host=127.0.0.1','root','');
        $builder = new Builder($connection);

        $builder
//            ->query("select (SELECT COUNT(*) total FROM associtation ) as association, (SELECT COUNT(*) total FROM benevole) as benevole")
            ->query("SELECT COUNT(*) total, (gouvernorat) gouvernorat, gouvernorat FROM association GROUP BY gouvernorat")
            ->addDataset('total','Total',[
                "backgroundColor" => RandomColorFactory::getRandomRGBAColors(24)
            ])
            ->labels('gouvernorat');

        $chart = $builder->buildChart('chart',Chart::PIE);
        $builder_two = new Builder($connection);

        $builder_two
//            ->query("select (SELECT COUNT(*) total FROM associtation ) as association, (SELECT COUNT(*) total FROM benevole) as benevole")
            ->query("SELECT COUNT(*) total, (gouvernorat) gouvernorat, gouvernorat FROM benevole GROUP BY gouvernorat")
            ->addDataset('total','Total',[
                "backgroundColor" => RandomColorFactory::getRandomRGBAColors(24)
            ])
            ->labels('gouvernorat');

        $chart_two = $builder_two->buildChart('chart_two',Chart::PIE);
        return $this->render('@Association/chart.html.twig',[
            "chart" => $chart,
            "chart_two" => $chart_two
        ]);
    }


    public function searchAction(Request $request){
        $associations = new Association();

        $searchTerm = $request->query->get('search');
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository(Association::class)->findOneBy(['raisonSociale' => $searchTerm]);
        //$results = $query->getResult();

        $content = $this->renderView('@Association/search.html.twig', [
            'res' => $results,
            'val' => $searchTerm

        ]);

        $response = new JsonResponse();
        $response->setData(array('list' => $content));
        return $response;
    }





}

