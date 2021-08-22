<?php

namespace ActualiteBundle\Controller;

use ActualiteBundle\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ActualiteBundle:Default:index.html.twig');
    }
    public function newannonceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new Annonce();
        $task->setTypeMission($request->get('type_mission'));
        $task->setPublicCible($request->get('public_cible'));
        $task->setDescription($request->get('description'));
        $task->setVille($request->get('ville'));
        $task->setCodePostal($request->get('code_postal'));
        $task->setImage($request->get('image'));
        $em->persist($task);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);
    }
    public function allAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('ActualiteBundle:Annonce')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function findAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('ActualiteBundle:Annonce')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $em2=$this->getDoctrine()
            ->getRepository('ActualiteBundle:Annonce');
        $sujet=$em2->find($id);
        $em->remove($sujet);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($sujet);
        return new JsonResponse($formatted);

    }
    public function editAction($id){
        $em=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository("ActualiteBundle:Annonce")->find($id);
            $em->persist($annonce);
            $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($annonce);
        return new JsonResponse($formatted);

    }
}
