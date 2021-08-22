<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Reponserc;
use ForumBundle\Entity\Spamsujetrc;
use ForumBundle\Entity\Sujetrc;
use ForumBundle\Entity\Votereponserc;
use ForumBundle\Entity\Votesujetrc;
use ForumBundle\ForumBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;


class DefaultController extends Controller
{






    public function getSubjectsAction(Request $request){ // affichage sujets
        $user = $this->getUser()->getId();
        $em2=$this->getDoctrine()->getRepository('ForumBundle:Reponserc');

        $em=$this->getDoctrine()->getRepository('ForumBundle:Sujetrc');
        $comment=$em2->findAll();
        $sujets=$em->findAll();

        if ($request->getMethod() == Request::METHOD_GET) {
            $name = $request->get('filter');
            $sujets = $this->getDoctrine()->getRepository(Sujetrc::class)->mefind($name);
        }
        $query = $sujets;
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 4));

        return $this->render('@Forum/Default/dispalySujets.html.twig',array('sujets'=>$result , "user"=>$user,"reponse"=>$comment));

    }
    public function detailSujetAction($id){

        $user = $this->getUser()->getId();

        $em=$this->getDoctrine()->getRepository('ForumBundle:Sujetrc');

        $sujet=$em->find($id); // hethi tlawajli el sujet existe ou pas, 7aseb el id passé en param

        $em2=$this->getDoctrine()->getRepository('ForumBundle:Reponserc');

        $comments=$em2->findBy(array('idSujet'=>$id)); //find el commentaire eli teba3 el sujet "X"

        $likes= $this->getDoctrine()->getRepository('ForumBundle:Votereponserc')->findAll(); //traja3lek kol shay mel table Votereponserc

        $votesujet=$this->getDoctrine()->getRepository('ForumBundle:Votesujetrc')->findAll(); // same

        $spam=$this->getDoctrine()->getRepository(Spamsujetrc::class)->findOneBy(array('idsujet'=>$id,"iduser"=>$user));

        if(is_null($spam))
        {
            $testsapm=true;
        }

        else
        {
            $testsapm=false;
        }

        return $this->render('@Forum/Default/detail.html.twig',array('sujet'=>$sujet,'comments'=>$comments,'likes'=>$likes,'user'=>$user
        ,'votes'=>$votesujet,'testsapm'=>$testsapm));

    }
    public function addrepAction(Request $request,$id)
    {    $user = $this->getUser();


        $comment=$request->get('comment');
        var_dump($comment);
        $em = $this->getDoctrine()->getManager();
        $reposne = new Reponserc();
        $reposne->contenu=$comment;
        $reposne->idSujet=$id;
        $reposne->dateresponse=new \DateTime();
        $reposne->user=$user;
        $em->persist($reposne);
        $em->flush();

        return $this->redirectToRoute('sujetByid',array('id'=>$id));
    }
    public function addSujetAction(Request $request){

        $user = $this->getUser();

        if($request->isMethod("POST")){
            $em = $this->getDoctrine()->getManager();
            $sujet = new Sujetrc();
            $sujet->contenu=$request->get('contenu');
            $sujet->datesujet=new \DateTime();
            $sujet->categorie=$request->get('categorie');
            $sujet->titresujet=$request->get('title');
            $sujet->image=$request->get('image');
            $sujet->user=$user;
            $em->persist($sujet);
            $em->flush();
            return $this->redirectToRoute('dispaly_all');
        }
        return $this->render('@Forum/Default/addsujet.html.twig');
    }
    public function likeAction($idrep,$id){
        $user = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $like=new Votereponserc();
        $like->idreponse=$idrep;
        $like->iduser=$user;
        $em->persist($like);
        $em->flush();
        return $this->redirectToRoute('sujetByid',array('id'=>$id));

    }
    public function dislikeAction($idrep,$id){
        $user = $this->getUser()->getId();

        $em2=$this->getDoctrine()
            ->getRepository('ForumBundle:Votereponserc');
        $em = $this->getDoctrine()->getManager();

        $like=$em2->findOneBy(array('idreponse'=>$idrep,'iduser'=>$user));
        $em->remove($like);
        $em->flush();
        return $this->redirectToRoute('sujetByid',array('id'=>$id));
    }




    public function deleteSujetAction($id){
        $em = $this->getDoctrine()->getManager();
        $em2=$this->getDoctrine()
            ->getRepository('ForumBundle:Sujetrc');
        $sujet=$em2->find($id);
        $em->remove($sujet);
        $em->flush();
        return $this->redirectToRoute('dispaly_all');

    }
    public function updateSujetAction($id){ //affichage
        $em2=$this->getDoctrine()
            ->getRepository('ForumBundle:Sujetrc');
        $sujet=$em2->find($id);
        return $this->render('@Forum/Default/updatesujet.html.twig',array('sujet'=>$sujet));

    }
    public function majSujetAction(Request $request,$id){ //update
        $em2=$this->getDoctrine()
            ->getRepository('ForumBundle:Sujetrc');
        $em=$this->getDoctrine()->getManager();
        $sujet=$em2->find($id);
        $sujet->titresujet=$request->get('title');
        $sujet->contenu=$request->get('contenu');
        $sujet->categorie=$request->get('categorie');
        $sujet->image=$request->get('image');

        $em->flush();
        return $this->redirectToRoute('sujetByid',array('id'=>$id));


    }
    public  function  updateCommentAction($id){ //affichage mta el view
        $em2=$this->getDoctrine()
            ->getRepository('ForumBundle:Reponserc');
        $comment=$em2->find($id);
        return $this->render('@Forum/Default/updateComment.html.twig',array("comment"=>$comment));

    }
    public  function majCommentAction(Request $request,$id,$idsujet){ //mise a jour hethi tekhdem el fct update
        $em2=$this->getDoctrine()
            ->getRepository('ForumBundle:Reponserc');
        $comment=$em2->find($id);
        $comment->contenu=$request->get('contenu');
        $em=$this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('sujetByid',array('id'=>$idsujet));
    }
    public function  deleterepAction($id,$idsujet){
        $em2=$this->getDoctrine()
            ->getRepository('ForumBundle:Reponserc');
        $reponse=$em2->find($id);
        $this->getDoctrine()->getManager()->remove($reponse);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('sujetByid',array('id'=>$idsujet));


    }
    public function  resolueAction($id){
        $em=$this->getDoctrine()->getRepository('ForumBundle:Sujetrc');

        $sujet = $em->find($id);
        $sujet->resolue=1;
        $this->getDoctrine()->getManager()->flush();
        return  $this->redirectToRoute('sujetByid',array('id'=>$id));
    }


    public function pushupAction($id){
        $user = $this->getUser()->getId();

        $em=$this->getDoctrine()->getRepository('ForumBundle:Votesujetrc'); // shnouwa far9 bin nestamelha bi find() wala blesh
        $em2=$this->getDoctrine()->getManager();

        $v=$em->findOneBy(array('iduser'=>$user,'idsujet'=>$id)); //

        if( is_null($v)){

            $vote = new Votesujetrc();
            $vote->idsujet=$id;
            $vote->iduser=$user;
            $vote->updown=1;
            $em2->persist($vote);
            $em2->flush();

        }
        else{
            $v->updown=1;
            $em2->flush();

        }
        return  $this->redirectToRoute('sujetByid',array('id'=>$id));
    }

    public function pushdownAction($id) {

        $user = $this->getUser()->getId();

        $em=$this->getDoctrine()->getRepository('ForumBundle:Votesujetrc');
        $em2=$this->getDoctrine()->getManager();

        $v=$em->findOneBy(array('iduser'=>$user,'idsujet'=>$id));

        if( is_null($v)){

            $vote = new Votesujetrc();
            $vote->idsujet=$id;
            $vote->iduser=$user;
            $vote->updown=0;
            $em2->persist($vote);
            $em2->flush();

        }else{
            $v->updown=0;
            $em2->flush();
        }
        return  $this->redirectToRoute('sujetByid',array('id'=>$id));

    }
    public function  deletevoteAction($id ,$idsujet){
        $vote=$this->getDoctrine()->getRepository('ForumBundle:Votesujetrc')->find($id);
        $this->getDoctrine()->getManager()->remove($vote);
        $this->getDoctrine()->getManager()->flush();


        return  $this->redirectToRoute('sujetByid',array('id'=>$idsujet));

    }

    public  function  signalezsujetAction($id){
        $user = $this->getUser()->getId();
        $s = $this->getDoctrine()->getRepository(Sujetrc::class)->find($id);
        $em=$this->getDoctrine()->getRepository(Spamsujetrc::class);
        $message = \Swift_Message::newInstance()
            ->setSubject('votre sujet a été signalé')
            ->setFrom('akram.jaiem.1@gmail.com')
            ->setTo($s->user->getEmail())
            ->setBody('Nous comptons sur les membres de notre communoté  pour signaler les contenus qui leur 
        paraissent inappropriés. 
        Votre sujet a été signalé plusieur pour contenu indesirable. Votre sujet sera effacé par l admin.');

        $em2=$this->getDoctrine()->getManager();
        $spam = new Spamsujetrc();
        $spam->idsujet=$id;
        $spam->iduser=$user;
        $em2->persist($spam);
        $em2->flush();

        $sujets = $em->findBy(array("idsujet"=>$id));
        if(sizeof($sujets)>=1){
            $this->get('mailer')
                ->send($message);

        }

        return  $this->redirectToRoute('sujetByid',array('id'=>$id));
    }



 /*   public function searchAction(Request $request){
        $user = $this->getUser()->getId();
        $em2=$this->getDoctrine()->getRepository('ForumBundle:Reponserc');

        $comments=$em2->findAll(); //find el commentaire eli teba3 el sujet "X"

        $mot=$request->get('search');
        $categorie=$request->get('categorie');
        $em=$this->getDoctrine()->getRepository('ForumBundle:Sujetrc');
        if(empty($mot) and $categorie=="all"){
            $sujets=$em->findAll();
        }elseif (empty($mot) and !$categorie=="all" ){
            $sujets=$em->findBy(array("categorie"=>$categorie));}
        elseif (!empty($mot)){
            $sujets=$em->findDQL($mot);
        }else{
            $sujets=$em->findBy(array("categorie"=>$categorie));
        }

        return $this->render('@Forum/Default/displayBy.html.twig',array('sujets'=>$sujets , "user"=>$user,"reponse"=>$comments));

    }*/
}
