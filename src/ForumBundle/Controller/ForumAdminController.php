<?php

namespace ForumBundle\Controller;


use ForumBundle\Entity\Reponserc;
use ForumBundle\Entity\Spamsujetrc;
use ForumBundle\Entity\Sujetrc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ForumAdminController extends Controller
{
    public function indexAction(Request $request)
    {
        $em=$this->getDoctrine()->getRepository(Sujetrc::class);
        $sujets = $em->findAll();

        if ($request->getMethod() == Request::METHOD_GET) {
            $name = $request->get('filter');
            $sujets = $this->getDoctrine()->getRepository(Sujetrc::class)->mefind($name);
        }

        return $this->render('@Forum/ForumAdmin/index.html.twig', array(
            'sujets'=>$sujets
        ));
    }
    public function  deleteAction(Request $request, $id){
        $sujet=new Sujetrc();
        $em=$this->getDoctrine()->getManager();
        $sujet=$em->getRepository("ForumBundle:Sujetrc")->find($id);
        $em->remove($sujet);
        $em->flush();
        return $this->redirectToRoute("admin_index_forun");
    }
    public function  detailsujetAction($id){
        $em=$this->getDoctrine()->getRepository(Reponserc::class);
        $em2=$this->getDoctrine()->getRepository(Sujetrc::class);
        $sujet=$em2->find($id);
        $reponses = $em->findBy(array('idSujet'=>$id));
        return $this->render('@Forum/ForumAdmin/detailsujetback.html.twig',array('sujet'=>$sujet,'reponses'=>$reponses));

    }

    public  function deleterepAction($id,$idsujet){
        $em=$this->getDoctrine()->getRepository(Reponserc::class);
        $reponse = $em->find($id);
        $this->getDoctrine()->getManager()->remove($reponse);
        $this->getDoctrine()->getManager()->flush();
        return  $this->redirectToRoute('detailback',array('id'=>$idsujet));

    }
    public function listsujetspamAction(Request $request){
        $em=$this->getDoctrine()->getRepository(Spamsujetrc::class);
        $sujetsapm=$em->findAll();
        $em2=$this->getDoctrine()->getRepository(Sujetrc::class);
        $sujets = array();
        return $this->render('@Forum/ForumAdmin/listsujetspam.html.twig',array('sujets'=>$sujets));

    }
    public function  deletespamAction($id){
        $em=$this->getDoctrine()->getRepository(Spamsujetrc::class);
        $sujet = $em->find($id);
        $this->getDoctrine()->getManager()->remove($sujet);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('sujetsapm');
    }
    public function searchAction(Request $request){
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

    }


}
