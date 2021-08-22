<?php

namespace AssoBundle\Controller;

use AssoBundle\Entity\chatbot;
use AssoBundle\Entity\message;
use AssoBundle\Entity\question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use AssoBundle\Form\messageType;

/**
 * @property \DateTime startDate
 */
class AdminassoController extends Controller
{

    /**
     * @Route("/Asso")
     */
    public function index_adminAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $quest = $em->getRepository(question::class)->findbyadmin();
        $usr = $em->getRepository(question::class)->findusradmin();




        if ($request->isMethod('POST')){

            if ($request->get('rechercher2'))
            {
                $catmat=$request->get('catmat2');

                if($catmat == 'Family'){
                    $quest = $em->getRepository(question::class)->findbyadmin();

                    $usrF = $em->getRepository(User::class)->findusrF();

                    return $this->render('@Asso/admin/tableUserFam.html.twig' , array('quest' => $quest, 'usrF'=>$usrF ));
                }


                else{
                    $quest = $em->getRepository(question::class)->findbyadmin();

                    $usr = $em->getRepository(question::class)->findusradmin();
                    return $this->render('@Asso/admin/tableAdmin2.html.twig' , array('quest' => $quest ,'usr' =>$usr  ));


                }
            }




            if ($request->get('rechercher'))
            {
                $catmat=$request->get('catmat');
                $catmatr=$request->get('catmatr');
                if ($catmatr == '1-2') {
                    $a = 1;
                    $b = 2;
                }
                elseif ($catmatr == '2-3'){
                    $a = 2;
                    $b = 3;
                }
                elseif ($catmatr == '3-4'){
                    $a = 3;
                    $b = 4;
                }
                elseif($catmatr == '4-5'){
                    $a = 4;
                    $b = 5;
                }


                if($catmat == 'User'){
                    $usr = $em->getRepository(question::class)->findusradmin();
                    $quest = $em->getRepository(question::class)->findbyuser($a ,$b);


                    return $this->render('@Asso/admin/tableAdminuser.html.twig' , array('quest' => $quest ,'usr' =>$usr   ));
                }











           // $repository=$this->getDoctrine()->getManager()->getRepository(question::class);
/*            if ($request->get('rechercher'))
            {
                $catmat=$request->get('catmat');
                $catmatr=$request->get('catmatr');


                if($catmat == 'User'){
                    $usr = $em->getRepository(question::class)->findusradmin();

                    if ($catmatr == '1-2') {
                        $quest = $em->getRepository(question::class)->findbyuser();
                    }
                    elseif ($catmatr == '2-3'){
                        $quest = $em->getRepository(question::class)->findbyuser();

                    }
                    elseif ($catmatr == '3-4'){
                        $quest = $em->getRepository(question::class)->findbyuser();
                    }
                    elseif($catmatr == '4-5'){
                        $quest = $em->getRepository(question::class)->findbyuser();

                    }

                    return $this->render('@Asso/admin/tableAdminuser.html.twig' , array('quest' => $quest ,'usr' =>$usr   ));
                }
*/

                else{
                    $usr = $em->getRepository(question::class)->findusradmin();

                    $quest = $em->getRepository(question::class)->findbyadmin();
                    return $this->render('@Asso/admin/tableAdmin2.html.twig' , array('quest' => $quest ,'usr' =>$usr   ));


                }
            }

        }

        return $this->render('@Asso/admin/tableAdmin2.html.twig' , array('quest' => $quest ,'usr' =>$usr  ));

    }

public function testAction(Request $request)
{
     $chk = $request ->get('chk');
        if ($chk) {
            return new response('hi');
        } else {
            return new response('hello');

        }


    }

    public function ajoutquestAction(Request $request){
        if ($request->isMethod('POST'))
        {


            $entityManager = $this->getDoctrine()->getManager();

            $quest = new question();


          //  $quest=$entityManager->getRepository(question::class ,$quest);
            if ($request->get('bt'))
            {

                $quest ->setQuest($request->get('ques'));
                $quest -> setRep( $request->get('ans'));
                $quest ->  setIdquest($request->get('id'));
                $quest->setDate(new \DateTime('now'));
                $quest->setUser('admin');
                $quest->setVal('5');
                $entityManager->persist($quest);

                $entityManager->flush();

                return $this->render('@Asso/admin/ajoutquest.html.twig');
            }

        }




        return $this->render('@Asso/admin/ajoutquest.html.twig');

    }



    public function mAction(Request $request,$id){


        if ($request->isMethod('POST'))
        {


            $entityManager = $this->getDoctrine()->getManager();

           // $quest = new question();


              $quest=$entityManager->getRepository(question::class)->find($id);
            if ($request->get('bt'))
            {

                $quest ->setQuest($request->get('ques'));
                $quest -> setRep( $request->get('ans'));
                $quest ->  setIdquest($request->get('id'));
                $quest->setDate(new \DateTime('now'));
                $quest->setUser('admin');
                $quest->setVal('5');
             //   $entityManager->persist($quest);

                $entityManager->flush();

                return $this->render('@Asso/admin/tableAdmin2.html.twig' );
            }

        }




        return $this->render('@Asso/admin/modifquest.html.twig',array('quest' => $quest));

    }



    public function rmuAction($id){

        $entityManager = $this->getDoctrine()->getManager();
        $quest = $entityManager->getRepository(question::class)->findbyuser();

        $club = $entityManager->getRepository(question::class)->find($id);
        $entityManager->remove($club);
        $entityManager->flush();
        return $this->render('@Asso/admin/tableAdminuser.html.twig' , array('quest' => $quest  ));

    }


    public function rmaAction($id){

        $entityManager = $this->getDoctrine()->getManager();
        $quest = $entityManager->getRepository(question::class)->findbyadmin();

        $club = $entityManager->getRepository(question::class)->find($id);
        $entityManager->remove($club);
        $entityManager->flush();
        return $this->render('@Asso/admin/tableAdmin2.html.twig' , array('quest' => $quest  ));

    }



    public function rmUserAction($id){

        $em = $this->getDoctrine()->getManager();

        $quest = $em->getRepository(question::class)->findbyadmin();
        $usr = $em->getRepository(question::class)->findusradmin();
        $club = $em->getRepository(User::class)->find($id);
if($club)
        {
            $em->remove($club);
            $em->flush();
            return $this->redirectToRoute('table_admin_asso');
        }

        return $this->render('@Asso/admin/tableAdmin2.html.twig' , array('quest' => $quest ,'usr' =>$usr ,'id'=>$id ));

    }










    public function ajouterpanierAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Panier::class);
        $mat= $this->getDoctrine()->getRepository(Materiel::class)->find($id);
        $user=$this->getDoctrine()->getRepository(Users::class)->findOneByEmail($this->getUser()->getemail());
        $email = $user->getEmail();
        $verif=$repository->panier_existe($email,$id);

        if ($request->isMethod('POST')) {
      //  $qt = ;
if ($request->get('demox')){
return new response('non vide');
}
else {
    return new response('vide');

}
        }


/*
        if ($request->isMethod('POST')) {
            $qt = $request->get('demox');
            var_dump($qt);


            if ($verif == false) {
                $panier = new Panier();
                $panier->setIduser($user);
                $panier->setRefmat($mat);
                // $panier->setQtach(1);
                $panier->setQtach($qt);
                //$mat->setQtmat(($mat->getQtmat()) - ($panier->getQtach()));
                $em = $this->getDoctrine()->getManager();
                $em->persist($panier);
                $em->flush();
                return $this->redirectToRoute('panier_userafficher');
            } else {
                $panier = $repository->rech_refmat($email, $id);
                //var_dump($panier);

                $panier[0]->setQtach(($panier[0]->getQtach()) + $qt);
                $mat->setQtmat(($mat->getQtmat()) - ($panier[0]->getQtach()));
                $em = $this->getDoctrine()->getManager();
                $em->persist($panier[0]);
                $em->flush();
                return $this->redirectToRoute('panier_userafficher');
            }
        }
*/
//        return $this->redirectToRoute('panier_afficher');
    }






}
