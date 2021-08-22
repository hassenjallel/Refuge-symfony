<?php


namespace AssoBundle\Controller;

use AssoBundle\Entity\chatbot;
use AssoBundle\Entity\message;
use AssoBundle\Entity\question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use AssoBundle\Form\questionType;
use Symfony\Component\Security\Http\Firewall\ContextListener ;
use AssoBundle\Entity\Notification;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @property \DateTime startDate
 */
class questionController extends Controller
{
    /**
     * @Route("/Asso")
     */
    public function helpAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $quest = $em->getRepository(question::class)->getquest();

       // $users = $em->getRepository(question::class)->findAll();
        $quest  = $this->get('knp_paginator')->paginate(
            $quest,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            2/*nbre d'éléments par page*/
        );
        return $this->render('@Asso/Default/help.html.twig',array(
            'quest' => $quest));
    }







    public function questAction(Request $request,$id ){

        $em = $this->getDoctrine()->getManager();
        $quest = $em->getRepository(question::class )->find($id);
        //$usr= $this->get('security.context')->getToken()->getUser();
        //$usr->getUsername();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        //  $veriff=$em->getRepository(question::class )->verif($questt,$username);
        $veriff=$em->getRepository(question::class )->findOneBy(['quest' => $quest -> getQuest('quest') ,'user' => $user ->getUsername()]);


   /*    if (!$veriff){
             return new response('hello');
       }
       else {
           return new response('laaa');

       }*/



        if( !$veriff ) {

             $question = new question();

             $form = $this->createForm(questionType::class, $question);
             $form = $form->handleRequest($request);
             if($form->isSubmitted())
             {
                 $em =$this->getDoctrine()->getManager();
                 $question->setQuest($request->get('quest'));
                 $question->setRep($request->get('rep'));
                 $question->setIdquest($request->get('id'));
                 $question->setDate(new \DateTime('now'));

                 $question->setUser($request->get('ques'));
                 $em->persist($question);
                 $em->flush();

              /*   $notification = new Notification();
                 $notification
                     ->setTitle($question-> getQuest())
                     ->setDescription('Rating : ',$question-> getVal())
                     ->setRoute('help')
                     ->setParameters(array('id' => $question-> getId()));

              $em->persist($notification);
                 $em->flush();
*/
                 //$pusher = $this -> get('mrad.pusher.notifications');
                // $pusher->trigger($notification);




                 return $this->redirectToRoute("val");
             }

}

        else  {


            $form = $this->createForm(questionType::class, $veriff);
            $form = $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $entityManager = $this->getDoctrine()->getManager();
                $veriff->setQuest($request->get('quest'));
                $veriff->setRep($request->get('rep'));
                $veriff->setIdquest($request->get('id'));
                $veriff->setDate(new \DateTime('now'));
                $veriff->setUser($request->get('ques'));
                $entityManager->persist($veriff);
                $entityManager->flush();


                return $this->redirectToRoute("val");

            }

        }

        return $this->render('@Asso/Default/quest.html.twig' ,array(   'quest' => $quest, "form" => $form->createView() ));


    }

    public function rmaAction($id){

        $entityManager = $this->getDoctrine()->getManager();
        $quest = $entityManager->getRepository(question::class)->findbyadmin();

        $club = $entityManager->getRepository(question::class)->find($id);
        $entityManager->remove($club);
        $entityManager->flush();
        return $this->render('@Asso/admin/tableAdmin2.html.twig' , array('quest' => $quest  ));

    }

    public function valAction()
    {
        $em = $this->getDoctrine()->getManager();
        $val = $em->getRepository(question::class)->getmoy();
        if(!empty($val)) {
            foreach ($val as $val1) {
                $val2 = $em->getRepository(question::class)->find($val1);

                $em->remove($val2);
                $em->flush();

            }

        }
        return $this->redirectToRoute("help");
       /// return new response('voila' . $val2->getIdquest() . 'voila');

    }


    public function modifier1Action(Request $request,$id )
    {
        $entityManager = $this->getDoctrine()->getManager();
        $club = $entityManager->getRepository(Club::class)->find($id);
        if($request->isMethod('POST'))
        {
            $club->setNom($request->get('nom'));
            $club->setDescription($request->get('description'));
            $club->setAdresse($request->get('adresse'));
            $club->setDomaine($request->get('domaine'));
            $entityManager->flush();
            return $this->redirectToRoute("ShowClub");
        }
        return $this->render('@Club/Club/Modifier.html.twig',array('club'=>$club));
    }

    public function mAction(Request $request,$id){

        $entityManager = $this->getDoctrine()->getManager();

        // $quest = new question();
        $quest = $entityManager->getRepository(question::class)->findAll();


        $quest2=$entityManager->getRepository(question::class)->find($id);

        if ($request->isMethod('POST'))
        {


            if ($request->get('bt'))
            {

                $quest2 ->setQuest($request->get('ques'));
                $quest2 -> setRep( $request->get('ans'));
                $quest2 ->  setIdquest($request->get('id'));
                $quest2->setDate(new \DateTime('now'));
                $quest2->setUser('admin');
                $quest2->setVal('5');
                //   $entityManager->persist($quest);

                $entityManager->flush();

                return $this->render('@Asso/admin/tableAdmin2.html.twig' ,array('quest' => $quest));
            }

        }




        return $this->render('@Asso/admin/modifquest.html.twig',array('quest2' => $quest2));

    }




    public function search22Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $users = $em->getRepository(question::class)->findEntitiesByString1($requestString);
        if (!$users) {
            $result['entities']['error'] = "Aucun resultat hey !";
        } else {
            $result['entities'] = $this->getRealEntities12($users);
        }
        return new Response(json_encode($result));
    }



    public function getRealEntities12($entities)
    {
        foreach ($entities as $users) {
            $realEntities[$users->getQuest()] = [$users->getQuest()];
        }
        return $realEntities;
    }





    /*
        public function modifierAction(Request $request,$id)
        {
            $entityManager = $this->getDoctrine()->getManager();
            $club = $entityManager->getRepository(Club::class)->find($id);
            $form = $this->createForm(ClubType::class, $club);
            $form = $form->handleRequest($request);
            if($form->isSubmitted())
            {
                $entityManager =$this->getDoctrine()->getManager();
                $entityManager->persist($club);
                $entityManager->flush();
                return $this->redirectToRoute("ShowClub");
            }
            return $this->render('@Club/Club/Ajout.html.twig',array('f'=>$form->createView()));
        }
    */















/*





    public function rediAction($questt,$username){

        $em = $this->getDoctrine()->getManager();
        $veriff=$em->getRepository(question::class )->verif($questt ,$username);

        if (!$veriff){
            return $this->redirectToRoute("ajout" ,['questt' => $questt]);

        }
        else {
            return $this->redirectToRoute("modif",['questt' => $questt ,'username'=>$username]);

        }

    }


    public function ajoutAction(Request $request,$questt ){

        $em = $this->getDoctrine()->getManager();
        $quest = $em->getRepository(question::class )->find($questt);

        $question = new question();

        $form = $this->createForm(questionType::class, $question);
        $form = $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em =$this->getDoctrine()->getManager();
            $question->setQuest($request->get('quest'));
            $question->setRep($request->get('rep'));
            $question->setIdquest($request->get('id'));
            $question->setDate(new \DateTime('now'));

            $question->setUser($request->get('ques'));
            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute("help");
        }

        return $this->render('@Asso/Default/quest.html.twig' ,array(   'quest' => $quest, "form" => $form->createView() ));


    }





    public function modifAction(Request $request,$questt,$username ){

        $em = $this->getDoctrine()->getManager();
        $quest = $em->getRepository(question::class )->find($questt);

        $veriff=$em->getRepository(question::class )->verif($questt ,$username);


        $form = $this->createForm(questionType::class, $veriff);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $veriff->setQuest($request->get('quest'));
            $veriff->setRep($request->get('rep'));
            $veriff->setIdquest($request->get('id'));
            $veriff->setDate(new \DateTime('now'));
            $veriff->setUser($request->get('ques'));
            $entityManager->persist($veriff);
            $entityManager->flush();


            return $this->redirectToRoute("help");

        }





        return $this->render('@Asso/Default/quest.html.twig' ,array(   'quest' => $quest, "form" => $form->createView() ));


    }

*/




















}