<?php


namespace AdminBundle\Controller;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;


class SomeController extends Controller
{
    public function pdfAction()
    {
        $vars =10;
        $this->get('knp_snappy.pdf')->generateFromHtml(
            $this->renderView(
                'AdminBundle/Default/pdf.html.twig',
                array(
                    'some'  => $vars
                )
            ),
            '/path/to/the/file.pdf'
        );
    }


}