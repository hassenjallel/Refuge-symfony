<?php

namespace UserBundle\Controller;

use AssoBundle\Entity\question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Form\UserType;

use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\HttpFoundation\File\UploadedFile;



use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Controller\SecurityController;
use UserBundle\Entity\User;


class DefaultController extends Controller
{




    /**
     * @Route("/user")
     */
    public function indexAction()
    {
        $u = $this->container->get('security.token_storage')->getToken()->getUser();
        try
        {
            switch ($u->getRoles()[0]) {
                case "ROLE_FAMILLE":
                    return $this->redirect('famille');
                    break;
                case "ROLE_ASSOCIATION":
                    return $this->redirect('association' );
                    break;
                case "ROLE_REFUGEE":
                    return $this->redirect('refuge');
                    break;
                case "ROLE_LIVREUR":
                    return $this->redirect('livreur' );
                    break;


                case "ROLE_FAMILLE_ADMIN":
                    return $this->redirect('admin/famille');
                    break;
                case "ROLE_ASSOCIATION_ADMIN":
                    return $this->redirect('admin/association' );
                    break;
                case "ROLE_REFUGEE_ADMIN":
                    return $this->redirect('admin/refuge');
                    break;
                case "ROLE_LIVREUR_ADMIN":
                    return $this->redirect('admin/livreur' );
                    break;



            }
        }
        catch (\Throwable $e)
        {
            return $this->render('index.html.twig');

        };

        return $this->render('@User/Default/index.html.twig');
    }










    public function livreur_ADMINAction()
    {

        return $this->render('@User/admin/homelivreur.html.twig');

    }

    public function association_ADMINAction()
    {

        return $this->render('@User/admin/homeassociation.html.twig');

    }
    public function famille_ADMINAction()
    {
        return $this->render('@User/admin/homefamille.html.twig');

    }
    public function refuge_ADMINAction()
    {
        return $this->render('@User/admin/homerefuge.html.twig');

    }









    public function livreurAction()
    {

        return $this->render('@User/Default/homelivreur.html.twig');

    }

    public function associationAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('eventBundle:event')->findAll();
        return $this->render('@User/Default/homeassociation.html.twig', array(
            'events' => $events,
        ));
//        return $this->render('@User/Default/homeassociation.html.twig');

    }
    public function familleAction()
    {
        return $this->render('@User/Default/homefamille.html.twig');

    }
    public function refugeAction()
    {
        return $this->render('@User/Default/homerefuge.html.twig');

    }






    public function showAssoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findusersbyrole("ROLE_ASSOCIATION");
        $users  = $this->get('knp_paginator')->paginate(
            $users,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/
        );
        return $this->render('@User/Default/showasso2.html.twig', array(
            'users' => $users
        ));
    }


    public function adminAction()
    {
        return $this->render('@User/Default/connexion.html.twig');

    }

    public function aAction()
    {
        return $this->render('@User/Default/connexion.html.twig');

    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $users = $em->getRepository(User::class)->findEntitiesByString1($requestString);
        if (!$users) {
            $result['entities']['error'] = "Aucun resultat";
        } else {
            $result['entities'] = $this->getRealEntities1($users);
        }
        return new Response(json_encode($result));
    }
    public function profileUserAction($username)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->getuserdatabyUsername($username);

        return $this->render('@User/Default/ProfileUser.html.twig', array(
            'users' => $users,
        ));
    }
    public function getRealEntities1($entities)
    {
        foreach ($entities as $users) {
            $realEntities[$users->getUsername()] = [$users->getUsername()];
        }
        return $realEntities;
    }



    public function editassoAction(Request $request,$id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
       // $user= new User();
        $form = $this->createForm(UserType::class, $user);
        $form = $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            /**
             * @var  UploadedFile $file
             */
            $file = $user->getImage();
           // if ($user->getImage()!=null){
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $file->move($this->getParameter('image_directory'),$fileName);
                $user->setImage($fileName);


          //  $user->setImage($user->getImage()->getClientOriginalName());

            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute("fos_user_profile_edit_asso");
        }
        return $this->render('@User/Default/editasso.html.twig',array('form_edit'=>$form->createView()));
    }
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }


    public function editrefAction(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form = $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute("fos_user_profile_edit_ref");
        }
        return $this->render('@User/Default/editref.html.twig',array('form_edit'=>$form->createView()));
    }

    public function editFamilleAction(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form = $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute("fos_user_profile_edit_famille");
        }
        return $this->render('@User/Default/editfamille.html.twig',array('form_edit'=>$form->createView()));
    }

    public function editLivAction(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form = $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $entityManager =$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute("fos_user_profile_edit_Liv");
        }
        return $this->render('@User/Default/editLiv.html.twig',array('form_edit'=>$form->createView()));
    }


    /**
     * @Route("/send-notification", name="send_notification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendNotification(Request $request)
    {
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification('Hello world !');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://symfony.com/');
        // or the one-line method :
        // $manager->createNotification('Notification subject','Some random text','http://google.fr');

        // you can add a notification to a list of entities
        // the third parameter ``$flush`` allows you to directly flush the entities
        $manager->addNotification(array($this->getUser()), $notif, true);

        return $this->redirectToRoute('homepage');
    }




    public function profileUser1Action($username)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->getuserdatabyUsername($username);

        return $this->render('@User/Default/ProfileUser1.html.twig', array(
            'users' => $users,
        ));
    }
    public function showRefAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findusersbyrole("ROLE_REFUGEE");
        $users  = $this->get('knp_paginator')->paginate(
            $users,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/
        );
        return $this->render('@User/Default/showref.html.twig', array(
            'users' => $users
        ));
    }



    public function search1Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $users = $em->getRepository(User::class)->findEntitiesByString11($requestString);
        if (!$users) {
            $result['entities']['error'] = "Aucun resultat";
        } else {
            $result['entities'] = $this->getRealEntities11($users);
        }
        return new Response(json_encode($result));
    }

    public function getRealEntities11($entities)
    {
        foreach ($entities as $users) {
            $realEntities[$users->getUsername()] = [$users->getUsername()];
        }
        return $realEntities;
    }


    public  function delAction($id, $username){
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->getuserdatabyUsername($id);

        $user = $em->getRepository(User::class)->find($username);

        if($user){
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute('show_ref');
        }
        return $this->render('@User/Default/showref.html.twig', array(
            'users' => $users
        ));
    }




    public function conAction($login,$mdp)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findA($login,$mdp);
        //->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }


}

