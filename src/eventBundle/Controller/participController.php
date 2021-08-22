<?php

namespace eventBundle\Controller;

use eventBundle\Entity\particip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Particip controller.
 *
 * @Route("particip")
 */
class participController extends Controller
{
    /**
     * Lists all particip entities.
     *
     * @Route("/", name="particip_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $particips = $em->getRepository('eventBundle:particip')->findAll();

        return $this->render('particip/index.html.twig', array(
            'particips' => $particips,
        ));
    }

    /**
     * Creates a new particip entity.
     *
     * @Route("/new/{{idevent}}/{{username}}", name="particip_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $particip = new Particip($request->get("idevent"),$request->get("username"));



            $em = $this->getDoctrine()->getManager();
            $em->persist($particip);
            $em->flush();
        $m = $this->getDoctrine()->getManager();

        $events = $m->getRepository('eventBundle:event')->findAll();
        return $this->render('@User/Default/homeassociation.html.twig', array(
            'events' => $events,
        ));


        //return $this->render('@User/Default/homeassociation.html.twig');
    }

    /**
     * Finds and displays a particip entity.
     *
     * @Route("particip/{id}", name="particip")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
       // $deleteForm = $this->createDeleteForm($particip);
        $result2=$this->getDoctrine()->getRepository(particip::class)->findparticipbyidevent($request->get("quantitedispo"));

        return $this->render('particip/show.html.twig', array(
            'particip' => $result2,
           // 'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing particip entity.
     *
     * @Route("/{id}/edit", name="particip_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, particip $particip)
    {
        $deleteForm = $this->createDeleteForm($particip);
        $editForm = $this->createForm('eventBundle\Form\participType', $particip);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('particip_edit', array('id' => $particip->getId()));
        }

        return $this->render('particip/edit.html.twig', array(
            'particip' => $particip,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a particip entity.
     *
     * @Route("/{id}", name="particip_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, particip $particip)
    {
        $form = $this->createDeleteForm($particip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($particip);
            $em->flush();
        }

        return $this->redirectToRoute('particip_index');
    }

    /**
     * Creates a form to delete a particip entity.
     *
     * @param particip $particip The particip entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(particip $particip)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('particip_delete', array('id' => $particip->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
