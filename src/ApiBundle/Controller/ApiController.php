<?php

namespace ApiBundle\Controller;

use DonBundle\Entity\Don;
use DonBundle\Entity\DonArgent;
use DonBundle\Form\DonArgentType;
use DonBundle\Form\DonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiController extends Controller
{
    public function listDonArgentApiAction()
    {
        $em = $this->getDoctrine()->getManager();
        $list_eq = $em->getRepository('DonBundle:DonArgent')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($list_eq);
        return new JsonResponse($formatted);
    }

    public function addDonAAction()
    {

        //            lehne aamlna creation taa form
        //$dateDon=date('Y-m-d');
        //$heureDon=date('H:i:s');
        $produit = new Don(0, 1, $this->getUser()->getId());
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        //hne jebnaaa doctrine
        $em = $this->getDoctrine()->getManager();
        //tawa bsh npersistiw
        $em->persist($produit);
        //tawa nflushiw
        $em->flush();
        $form = $this->createForm(DonType::class);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);

    }

    public function addDonArgentAction(Request $request, DonArgent $donArgent = null)
    {

        //            lehne aamlna creation taa form
        $donArgent = new DonArgent();
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT max(p.idDon)
            FROM DonBundle\Entity\Don p
            ');

        // returns an array of Product objects
        $idd = $query->getResult();
        //$idd=$this->findMax();
        //$iddd=reset($idd);
        // $produit.setidDon(100);
        $form = $this->createForm(DonArgentType::class, $donArgent);
        //lehne bsh naadyw requete
        $form = $form->handleRequest($request);
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        if ($form->isSubmitted() && $form->isValid()) {
            //hne jebnaaa doctrine
            //$produit.setidDon();
            $em = $this->getDoctrine()->getManager();
            //tawa bsh npersistiw
            $em->persist($donArgent);
            //tawa nflushiw
            $em->flush();
            $em->createQuery("UPDATE DonBundle:DonArgent c SET c.idDon = :ids WHERE c.idDon in (0)")
                ->setParameter(':ids', $idd[0])
                ->execute();
            return $this->redirectToRoute('don_listDonArgentf');

        }
        //hne rajaa3na render taa page ajout
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($form);
        return new JsonResponse($formatted);
    }

    public function deleteDonArgentAction($idDon)
    {
        $produit = $this->getDoctrine()->getRepository(DonArgent::class)->find($idDon);
        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        $em->createQuery("Delete from DonBundle:Don c  WHERE c.idDon = :ids")
            ->setParameter(':ids', $idDon)
            ->execute();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }
    public function addDonAction (){
        $produit = new Don(0,1,1);
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        //hne jebnaaa doctrine
        $em=$this->getDoctrine()->getManager();
        //tawa bsh npersistiw
        $em->persist($produit);
        //tawa nflushiw
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);

    }

    public function addDonArgentApiAction(Request $request){
        //            lehne aamlna creation taa fo
        $entitymanager = $this->getDoctrine()->getManager();
//$events = $entitymanager->getRepository(Don::class)->findLogBy();
        $query = $entitymanager->createQuery( 'SELECT max(p.idDon)
            FROM DonBundle:Don p');
       $events=$query->getResult();

        $donArgent=new DonArgent();
        // returns an array of Product objects
       // $idd=$query->getResult();
        //$donArgent->setIdDon($events);
        $donArgent->setSomme($request->get('somme'));
            //tawa bsh npersistiw
        $entitymanager->persist($donArgent);
            //tawa nflushiw
        $entitymanager->flush();
       $dd= $entitymanager->createQuery("UPDATE DonBundle:DonArgent c SET c.idDon = :ids WHERE c.idDon in (0)")
            ->setParameter(':ids',$events[0])
           ->execute();
        $d=[$donArgent,$dd];
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($d);
        return new JsonResponse($formatted);

    }

    public function PointsAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT sum(a.somme) from 
DonBundle\Entity\DonArgent a inner JOIN DonBundle\Entity\Don d WHERE a.idDon = d.idDon and d.idUser=1
');


        $list_DonArgent=$query->getResult();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($$list_DonArgent);
        return new JsonResponse($formatted);
    }


}
