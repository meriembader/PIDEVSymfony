<?php

namespace Projet\ProjBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Projet\ProjBundle\Form\MailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Projet\ProjBundle\Entity\Contactmail;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('@ProjetProj/Default/index.html.twig');
    }

    public function offreAction()
    {
        return $this->render('@ProjetProj/Default/offre1.html.twig');
    }

    public function aoffreAction()
    {
        return $this->render('@ProjetProj/Default/offreA.html.twig');
    }

    public function boffreAction()
    {
        return $this->render('@ProjetProj/Default/offreB.html.twig');
    }

    /**
     *
     * @Route("/lesformation", name="proj_formpage")
     */
    public function formationpageAction()
    {
        return $this->render('@ProjetProj/Default/formation.html.twig');
    }

    public function demandeadminAction()
    {
        return $this->render('@ProjetProj/Default/demande.html.twig');
    }

    /**
     *
     * @Route("/contactform", name="proj_contactformation")
     */

    public function formationcontactAction(Request $request)
    {
        $contact = new Contactmail();
        $form = $this->createForm('Projet\ProjBundle\Form\ContactmailType', $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $name = $contact->getName();
            $mail = $contact->getEmail();
            $subject = $contact->getSubject();
            $message = $request->get('form')['message']."demande de formation envoyée avec succés vous receverez une réponse bientôt";
            $username = 'testmaritest123@gmail.com';
            $text = \Swift_Message::newInstance()->setSubject($subject)->setFrom($username)
                ->setTo($mail)->setBody($message);
            $this->get('mailer')->send($text);
            $this->get('session')->getFlashBag('notice', 'Message envoyé avec succés');

        }


        return $this->render('@ProjetProj/Default/my_email.html.twig', array(
            'form' => $form->createView(),
        ));


    }

    public function pdf1Action(Request $request)
    {
        $snappy = $this->get('knp_snappy.pdf');
        $snappy->setOption("encoding", "UTF-8");

        $html = '<h1>Teltway Building</h1> <br> 
                  <p> Chaque année, 330 000 collaborateurs (f/h) travaillent dans nos 60 000 entreprises clientes. Rejoignez-nous ! <br>

            Spécialisée dans les métiers du transport et de la conduite, <br>
            l\'agence Teltway Building vous offre de nombreuses opportunités d\'emploi et vous accompagne tout au long de votre carrière. <br>
        </p> <br> ';

        $filename = 'Teltway Building';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.pdf"'
            )
        );

    }

    public function pdf2Action(Request $request)
    {
        $snappy = $this->get('knp_snappy.pdf');
        $snappy->setOption("encoding", "UTF-8");

        $html = '<h1>Service Clientèle</h1> <br> 
                  <p>
            Votre mission sera d’orienter nos clients et prospects et de leur apporter un conseil personnalisé. Ainsi vous développerez l’expérience client 2.0. <br>

            Conseiller à distance, oui, mais surtout contact privilégié de nos clients ! <br>

            Nos clients compteront sur vous pour les orienter, les conseiller sur tous les sujets de la banque au quotidien <br>
            et réaliser leurs opérations bancaires en ligne. <br> <br>

            <b>Les missions c’est important, l’équipe et l’environnement de travail aussi ! </b> <br>
        </p> ';

        $filename = 'Service Clientèle';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.pdf"'
            )
        );

    }

    public function sendAction(Request $request)
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
        return $this->render('@ProjetProj/Default/my_email.html.twig', array('form' => $form->createView(),));

    }
    /**
     *
     * @Route("/formation_mail", name="proj_for")
     */

    public function contactAction(Request $request)
    {
        // Create the form according to the FormType created previously.
        // And give the proper parameters
        $form = $this->createForm('Projet/ProjBundle/Form/MailType.php', null, array(
            // To set the action use $this->generateUrl('route_identifier')
            'action' => $this->generateUrl('proj_for'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            // Refill the fields in case the form is not valid.
            $form->handleRequest($request);

            if ($form->isValid()) {
                // Send mail
                if ($this->sendEmail($form->getData())) {

                    // Everything OK, redirect to wherever you want ! :

                    return $this->redirectToRoute('proj_contactformation');
                } else {
                    // An error ocurred, handle
                    var_dump("Error :(");
                }
            }
        }

        return $this->render('@ProjetProj/Default/my_email.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function sendEmail($data)
    {
        $myappContactMail = 'testmaritest123@gmail.com';
        $myappContactPassword = 'password123/*-';

        // In this case we'll use the ZOHO mail services.
        // If your service is another, then read the following article to know which smpt code to use and which port
        // http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("Our Code World Contact Form " . $data["subject"])
            ->setFrom(array($myappContactMail => "Message by " . $data["name"]))
            ->setTo(array(
                $myappContactMail => $myappContactMail
            ))
            ->setBody($data["message"] . "<br>ContactMail :" . $data["email"]);

        return $mailer->send($message);
    }

}
