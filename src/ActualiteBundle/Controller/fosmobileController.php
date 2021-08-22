<?php

namespace ActualiteBundle\Controller;

use ActualiteBundle\Entity\Annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use ActualiteBundle\Entity\fosmobile;

class fosmobileController extends Controller
{
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $mob = new fosmobile($request->get('login_db'),$request->get('email_db'),$request->get('mdp_db'),$request->get('roles'));

        $em->persist($mob);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($mob);
        return new JsonResponse($formatted);
    }
    public function cnxAction(Request $request)
    {
        $result2=$this->getDoctrine()->getRepository(fosmobile::class)->cnx($request->get('login_db'),$request->get('mdp_db'));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($result2);
        return new JsonResponse($formatted);
    }
    public function editAction(Request $request)
    {    $em = $this->getDoctrine()->getManager();

        $review=$this->getDoctrine()->getRepository(fosmobile::class)->findfosbyusername($request->get('login_db'));
        foreach($review as $item ) {
            $item->setUsername($request->get('login_db'));
            $item->setEmail($request->get('email_db'));
            $item->setRole($request->get('roles'));
            $item->setPassword($request->get('mdp_db'));

            $em->flush();
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($review);
        return new JsonResponse($formatted,200);
    }
}
