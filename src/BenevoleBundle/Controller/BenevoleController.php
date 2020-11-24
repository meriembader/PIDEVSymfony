<?php

namespace BenevoleBundle\Controller;

use BenevoleBundle\Entity\Benevole;
use Dompdf\Dompdf;
use Dompdf\Options;
use Mukadi\Chart\Builder;
use Mukadi\Chart\Chart;
use Mukadi\Chart\Utils\RandomColorFactory;
use PDO;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Benevole controller.
 *
 */
class BenevoleController extends Controller
{
    /**
     * Lists all benevole entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $listBenevoles = $em->getRepository('BenevoleBundle:Benevole')->findAll();
        $benevoles = $this->get('knp_paginator')->paginate(
            $listBenevoles,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            4/*nbre d'éléments par page*/
        );
        return $this->render('benevole/index.html.twig', array(
            'benevoles' => $benevoles,
        ));
    }

    /**
     * Creates a new benevole entity.
     *
     */
    public function newAction(Request $request)
    {
        $benevole = new Benevole();
        $form = $this->createForm('BenevoleBundle\Form\BenevoleType', $benevole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($benevole);
            $em->flush();

            return $this->redirectToRoute('benevole_show', array('id' => $benevole->getId()));
        }

        return $this->render('benevole/new.html.twig', array(
            'benevole' => $benevole,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a benevole entity.
     *
     */
    public function showAction(Benevole $benevole)
    {
        $deleteForm = $this->createDeleteForm($benevole);

        return $this->render('benevole/show.html.twig', array(
            'benevole' => $benevole,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing benevole entity.
     *
     */
    public function editAction(Request $request, Benevole $benevole)
    {
        $deleteForm = $this->createDeleteForm($benevole);
        $editForm = $this->createForm('BenevoleBundle\Form\BenevoleType', $benevole);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('benevole_edit', array('id' => $benevole->getId()));
        }

        return $this->render('benevole/edit.html.twig', array(
            'benevole' => $benevole,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a benevole entity.
     *
     */
    public function deleteAction(Request $request, Benevole $benevole)
    {
        $form = $this->createDeleteForm($benevole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($benevole);
            $em->flush();
        }

        return $this->redirectToRoute('benevole_index');
    }

    /**
     * Creates a form to delete a benevole entity.
     *
     * @param Benevole $benevole The benevole entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Benevole $benevole)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('benevole_delete', array('id' => $benevole->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function pdfAction()
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $em = $this->getDoctrine()->getManager();

        $benevoles = $em->getRepository('BenevoleBundle:Benevole')->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('benevole/listB.twig', array(
            'benevoles' => $benevoles,
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
     * excel a benevole entity.
     *
     */
    public function ExcelAction()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1','Cin');
        $sheet->setCellValue( 'C1','address');
        $sheet->setCellValue( 'D1','mail ');
        $sheet->setCellValue( 'E1','telephone ');
        $sheet->setCellValue('F1','niveau ');
        $sheet->setCellValue('G1','gouvernorat ');
        $sheet->setTitle("Liste des Benevoles");

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        // Create a Temporary file in the system
        $fileName = 'ExcelFile.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $em = $this->getDoctrine()->getManager();

        $benevoles = $em->getRepository('BenevoleBundle:Benevole')->findAll();

        $html = $this->renderView('benevole/listBexcel.html.twig', array(
            'benevoles' => $benevoles,
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
            ->query("SELECT COUNT(*) total, (gouvernorat) gouvernorat, gouvernorat FROM benevole GROUP BY gouvernorat")
            ->addDataset('total','Total',[
                "backgroundColor" => RandomColorFactory::getRandomRGBAColors(24)
            ])
            ->labels('gouvernorat');

        $chart = $builder->buildChart('chart',Chart::PIE);
        return $this->render('@Benevole/chart.html.twig',[
            "chart" => $chart,
        ]);
    }

}
