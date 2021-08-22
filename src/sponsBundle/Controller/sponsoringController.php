<?php

namespace sponsBundle\Controller;

use sponsBundle\Entity\besoins;
use sponsBundle\Entity\sponsoring;
use stockBundle\Entity\stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserBundle;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sponsoring controller.
 *
 * @Route("sponsoring")
 */
class sponsoringController extends Controller
{
    /**
     * Lists all sponsoring entities.
     *
     * @Route("/", name="sponsoring_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sponsorings = $em->getRepository('sponsBundle:sponsoring')->findAll();


        return $this->render('sponsoring/index.html.twig', array(
            'sponsorings' => $sponsorings,
        ));
    }
    /**
     * Lists all sponsoring entities.
     *
     * @Route("/besoins", name="sponsoring_besoins")
     * @Method("GET")
     */
    public function besoinsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $besoins = $em->getRepository('sponsBundle:besoins')->findAll();
        $result=$this->getDoctrine()->getRepository(besoins::class)->findbesoins();
        foreach($result as $item ){
            $result2=$this->getDoctrine()->getRepository(besoins::class)->findbesoinsbynomproduit($item->getNomProduit());
            if(!$result2){
                $em = $this->getDoctrine()->getManager();
                $nos_besoins=100-$item->getQuantiteDispo();


                $newItem = new besoins($item->getNomProduit(),$item->getQuantiteDispo(),$nos_besoins);
                $em->persist($newItem);
                $em->flush();
            }

        }
        return $this->render('sponsoring/besoins.html.twig', array(
            'besoins' => $besoins,
        ));
    }
    /**
     * Lists all sponsoring entities.
     *
     * @Route("/besoins_user", name="sponsoring_besoins_user")
     * @Method("GET")
     */
    public function besoinsUserAction()
    {
        $em = $this->getDoctrine()->getManager();

        $besoins = $em->getRepository('sponsBundle:besoins')->findAll();
        $result=$this->getDoctrine()->getRepository(besoins::class)->findbesoins();
        foreach($result as $item ){
            $result2=$this->getDoctrine()->getRepository(besoins::class)->findbesoinsbynomproduit($item->getNomProduit());
            if(!$result2){
                $em = $this->getDoctrine()->getManager();
                $nos_besoins=100-$item->getQuantiteDispo();


                $newItem = new besoins($item->getNomProduit(),$item->getQuantiteDispo(),$nos_besoins);
                $em->persist($newItem);
                $em->flush();
            }

        }
        return $this->render('sponsoring/besoinsUser.html.twig', array(
            'besoins' => $besoins,
        ));
    }
    /**
     * Creates a new sponsoring entity.
     *
     * @Route("/new", name="sponsoring_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sponsoring = new Sponsoring();
        $form = $this->createForm('sponsBundle\Form\sponsoringType', $sponsoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sponsoring);
            $em->flush();

           // return $this->redirectToRoute('sponsoring_show', array('id' => $sponsoring->getId()));
            return $this->render('@User/Default/homeassociation.html.twig');

        }

        return $this->render('sponsoring/new.html.twig', array(
            'sponsoring' => $sponsoring,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sponsoring entity.
     *
     * @Route("/{id}", name="sponsoring_show")
     * @Method("GET")
     */
    public function showAction(sponsoring $sponsoring)
    {
        $deleteForm = $this->createDeleteForm($sponsoring);

        return $this->render('sponsoring/show.html.twig', array(
            'sponsoring' => $sponsoring,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Finds and displays a sponsoring entity.
     *
     * @Route("/{nomProduit}/{quantite}/{quantitedispo}/{nos_besoins}/help", name="help")
     * @Method("GET")
     */
    public function help(Request $request)
    {
        $result=$this->getDoctrine()->getRepository(besoins::class)
            ->update($request->get("nomProduit"),$request->get("quantite"),$request->get("quantitedispo"));




  $x = $request->get("nos_besoins")-$request->get("quantite");
         if($x<0) {
             $result = $this->getDoctrine()->getRepository(besoins::class)->deleteBes($request->get("nomProduit"));
               $y = $request->get("quantitedispo")+$request->get("quantite") ;
               $request=$this->getDoctrine()->getRepository(besoins::class)->updateStock($request->get("nomProduit"), $y);
             return new JsonResponse($request->get("deleted"), Response::HTTP_OK);

//
         }
        return new JsonResponse("updated", Response::HTTP_OK);
    }

    /**
     * Displays a form to edit an existing sponsoring entity.
     *
     * @Route("/{id}/edit", name="sponsoring_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, sponsoring $sponsoring)
    {
        $deleteForm = $this->createDeleteForm($sponsoring);
        $editForm = $this->createForm('sponsBundle\Form\sponsoringType', $sponsoring);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sponsoring_edit', array('id' => $sponsoring->getId()));
        }

        return $this->render('sponsoring/edit.html.twig', array(
            'sponsoring' => $sponsoring,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sponsoring entity.
     *
     * @Route("/{id}", name="sponsoring_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, sponsoring $sponsoring)
    {
        $form = $this->createDeleteForm($sponsoring);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sponsoring);
            $em->flush();
        }

        return $this->redirectToRoute('sponsoring_index');
    }

    /**
     * Creates a form to delete a sponsoring entity.
     *
     * @param sponsoring $sponsoring The sponsoring entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(sponsoring $sponsoring)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sponsoring_delete', array('id' => $sponsoring->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
