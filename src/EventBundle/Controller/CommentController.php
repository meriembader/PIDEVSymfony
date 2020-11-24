<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Comment;
use EventBundle\Entity\Event;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    public function addCommentAction(Request $request)
    {
        $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository(Event::class)->find($request->get('id_event'));
        $contenue           =   $request->get('contenue');
        $comment = new Comment();
        $comment->setContenue($contenue);
        $comment->setEvent($event);
        $comment->setUser($user);
        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute('event_show',['id'=> $request->get('id_event')]);
    }

    public function commentsPdfAction()
    {
        $em=$this->getDoctrine()->getManager();
        $events=$em->getRepository(Event::class)->findAll();
        $html = $this->renderView('EventBundle:Comment:show_comment_by_id_event.html.twig', array(
            'events'  => $events
        ));

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'file.pdf'
        );
    }

}
