<?php

namespace EspritApiBundle\Controller;

#use http\Env\Request;
use AppBundle\Entity\User;
use AssociationBundle\Entity\Association;
use BenevoleBundle\Entity\Benevole;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;


class DefaultController extends Controller
{
    public function allAction()
    {
        $notes = $this->getDoctrine()->getManager()->getRepository('AssociationBundle:Association')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($notes);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $Associations = new Association();
        $Associations->setRaisonSociale($request->get('raisonSociale'));
        $Associations->setAddress($request->get('address'));
        $Associations->setTelephone($request->get('telephone'));
        $Associations->setDomaine($request->get('domaine'));
        $Associations->setGouvernorat($request->get('gouvernorat'));
        $em -> persist($Associations);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Associations);
        return new JsonResponse($formatted);
    }



    /*********************************Benevole ***************************/

    public function allBenevoleAction()
    {
        $notes = $this->getDoctrine()->getManager()->getRepository('BenevoleBundle:Benevole')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($notes);
        return new JsonResponse($formatted);
    }

    public function newBenevoleAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $Benevoles = new Benevole();
        $Benevoles->setCin($request->get('cin'));
        $Benevoles->setAddress($request->get('address'));
        $Benevoles->setMail($request->get('mail'));
        $Benevoles->setTelephone($request->get('telephone'));
        $Benevoles->setNiveau($request->get('niveau'));
        $Benevoles->setGouvernorat($request->get('gouvernorat'));
        $em -> persist($Benevoles);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Benevoles);
        return new JsonResponse($formatted);
    }
/************************************** User ****************************/



    public function newUserAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $Users = new User();
        $Users->setUsername($request->get('username'));
        $Users->setEmail($request->get('email'));
        $Users->setPassword($request->get('password'));


        $em -> persist($Users);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Users);
        return new JsonResponse($formatted);
    }
    public function allUserAction()
    {
        $notes = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($notes);
        return new JsonResponse($formatted);
    }
    public function loginAction(Request $request)
    {
        $users = $this->getDoctrine()->getManager()
            ->getRepository(User::class)->findAll();
        foreach ($users as $user) {
            if ($user->getUsername() == $request->get('username')) {
                if ($user->getPassword() == $request->get('password')) {
                    $dd = $user->getId();
                    $serializer = new Serializer([new ObjectNormalizer()]);
                    $formatted = $serializer->normalize($dd);
                  //  var_dump($formatted);

                    return new JsonResponse(1);

                }
            }
        }
        return new JsonResponse(0);

    }

    // when the user is mandatory (e.g. behind a firewall)
    public function lolAction(UserInterface $user)
    {
        $userId = $user->getId();
    }

    // when the user is optional (e.g. can be anonymous)
    public function barAction(UserInterface $user = null)
    {
        $userId = null !== $user ? $user->getId() : null;
    }
    /* public function loginAction(Request $request)
   {
       $users = $this->getDoctrine()->getManager()
           ->getRepository(User::class)->findAll();
       foreach ($users as $user) {
           if ($user->getUsername() == $request->get('username')) {
               if ($user->getPassword() == $request->get('password')) {
                   # return new JsonResponse(1);
                   #recupération id  user
                   $em = $this->getDoctrine()->getManager()->this->getId();
                 //  $x =  $this->getUser()->getId();
                   $y =intval($em);

                   $serializer = new Serializer([new ObjectNormalizer()]);
                   $formatted = $serializer->normalize($y);
                   return new JsonResponse($y);
               }
           }
       }
       return new JsonResponse(0);

   }*/



}
