<?php

namespace Projet\ProjBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Projet\ProjBundle\Entity\MyDemande;
use Projet\ProjBundle\Entity\FosUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
class MobileController extends Controller
{
    /**
     *
     * @Route("/mydemande/all", name="all")
     */
    public function allAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('ProjetProjBundle:MyDemande')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    /**
     *
     * @Route("/offre/all", name="all2")
     */
    public function all2Action()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('ProjetProjBundle:MyOffre')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function findDAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('ProjetProjBundle:MyDemande')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    /**
     *
     * @Route("/newD", name="newD")
     */
    public function newDAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new MyDemande();
        $task->setDate($request->get('date'));
        $task->setLibelle($request->get('libelle'));
        $em->persist($task);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);
    }
    public function insignAction($username,$password)
    {

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);

        $_username = $username;
        $_password = $password;
        $factory = $this->get('security.encoder_factory');

        $user_manager = $this->get('fos_user.user_manager');
        $user = $user_manager->findUserByUsername($_username);
        // Or by yourself
        $user = $this->getDoctrine()->getManager()->getRepository("ProjetProjBundle:FosUser")
            ->findOneBy(array('username' => $_username));

        if(!$user){
            return
                new response( 'Username doesnt exists' );

        }


        $encoder = $factory->getEncoder($user);
        $salt = $user->getSalt();

        if(!$encoder->isPasswordValid($user->getPassword(), $_password, $salt)) {
            return
                new response( 'Username or Password not valid.');
        }

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);

        $this->get('session')->set('_security_main', serialize($token));


        $serializer = new Serializer($normalizers, [new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);



    }
    public function deletedemAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cl = $em->getRepository('ProjetProjBundle:MyDemande')->find($id);
        $em->remove($cl);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($cl);
        return new JsonResponse($formatted);

    }




}
