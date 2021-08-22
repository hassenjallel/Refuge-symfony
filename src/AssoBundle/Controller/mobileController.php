<?php

namespace AssoBundle\Controller;

use AssoBundle\Entity\chatbot;
use AssoBundle\Entity\message;
use AssoBundle\Entity\question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\User;
use AssoBundle\Form\messageType;

/**
 * @property \DateTime startDate
 */
class mobileController extends Controller
{

    /**
     * @Route("/Asso")
     */






    public function allAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function ListLoginAction($s)
    {
if ($s =='[ROLE_ASSOCIATION]') {
    $tasks = $this->getDoctrine()->getManager()
        ->getRepository(message::class)
        ->findlogiasso();
}
else if ($s == '[ROLE_FAMILLE]'){

    $tasks = $this->getDoctrine()->getManager()
        ->getRepository(message::class)
        ->findloginfam();
}

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function msgAction($loginEnvoi ,$loginRecep)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(message::class)
          ->getMesagemob( $loginEnvoi ,$loginRecep);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function newAction(Request $request,$idMessage , $loginEnvoi , $loginRecep,$msg)
    {
        /*  $em = $this->getDoctrine()->getManager();
          $task = new message();
          $task->setName($request->get('name'));
          $task->setStatus($request->get('status'));


  */


        $em = $this->getDoctrine()->getManager();


        $message2 = new message();

        $message2 ->setIdMessage($idMessage);

        $message2 ->setLoginEnvoi($loginEnvoi);

        $message2->setLoginRecep($loginRecep);

        $message2->setMessage($msg);
        $message2->setDate(new \DateTime('now'));
        $message2->setRole('Association');

        $message2->setIdRecep($idMessage);



        $em->persist($message2);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($message2);
        return new JsonResponse($formatted);
    }

    public function adduserAction(Request $request,$nom , $username , $email,$password,$roles,$tel,$pays ,$code,$add)
    {
        $em = $this->getDoctrine()->getManager();

        $u = new User();

/*
        /**
         * @var  UploadedFile $file
         */
        //$file = $user->getImage();
        // if ($user->getImage()!=null){
      // $fileName = $this->generateUniqueFileName().'.'.$image->guessExtension();
       // $image =($request->get('image'));
     /*   $image = $request->files->get('image');

        if($image) {
            $filename = uniqid() . "." . $image->getClientOriginalExtension();
            $image->move($this->getParameter('image_directory'), $filename);
            $u->setImage($filename);

*/
            $u->setNom($nom);
            $u->setUsername($username);
            $u->setEmail($email);
            $u->setPassword($password);

            $u->setRoles(array($roles));
            $u->setTel($tel);
            $u->setPays($pays);
            $u->setCode($code);
        $u->setAdd($add);
        $u->setEtat("not actif");
            $em->persist($u);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($u);
            return new JsonResponse($formatted);

    }



    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * Check password login
     *
     * @Route("/getcode", name="code_login")
     * @Method({"GET", "POST"})
     *
     */
    public function getCodeAction(Request $request)
    {

        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
        $user = $user_manager->findUserByUsername($request->get('user'));
        $encoder = $factory->getEncoder($user);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user->getCode());
        return new JsonResponse($formatted);

    }


    public function envoyezMailAction(Request $request)
    {
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 25, 'tls')
            ->setUsername('wadie.belghith1@esprit.tn')
            ->setPassword('qjspnpcirupavi')
        ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));

        $mailer = new \Swift_Mailer($transport);

        $message=(new \Swift_Message('Voici Votre Code de Confirmation '))
            ->setFrom('wadie.belghith1@esprit.tn')
            ->setTo($request->get('email'))

            //  ->setBody('<h3> Bonjour  </h3>' . $contact->getNom()."Votre Message a eté envoyée avec success",'text/html');

            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'mailconfirm.html.twig',

                    ['code' => $request->get('code')]

                ),
                'text/html'
            );
        $mailer->send($message);
        ////
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("sent");
        return new JsonResponse($formatted);

    }

    public function UserverifaicationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
        $user = $user_manager->findUserByUsername($request->get('user'));

        $user->setEtat("Active");
        $em->persist($user);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }



    public function LoginAction($username, $password)
    {

        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
        $user = $user_manager->findUserByUsername($username);
        $encoder = $factory->getEncoder($user);

        $users = $this->getDoctrine()->getRepository(User::class)->findBy(array('username'=>$username));
        $bool = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? "true" : "false";

        if($user->getEtat()=="Attente")
        {
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize(123);
            return new JsonResponse($formatted);
        }
        elseif ($bool == "false" )
        {
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize(false);
            return new JsonResponse($formatted);
        }
        else
        {

            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($users);
            return new JsonResponse($formatted);
        }

    }
/*
    public function  userdataAction(Request $request,$username){
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
               ->find($username);


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

*/


    public function updateuserAction(Request $request,$id,$nom , $username , $email,$password,$tel,$pays ,$add)
    {
        $em = $this->getDoctrine()->getManager();

       // $u = $em->getRepository(User::class)->findAl($username);
        $u = $em->getRepository(User::class)->find($id);

        /*
                /**
                 * @var  UploadedFile $file
                 */
        //$file = $user->getImage();
        // if ($user->getImage()!=null){
        // $fileName = $this->generateUniqueFileName().'.'.$image->guessExtension();
        // $image =($request->get('image'));
        /*   $image = $request->files->get('image');

           if($image) {
               $filename = uniqid() . "." . $image->getClientOriginalExtension();
               $image->move($this->getParameter('image_directory'), $filename);
               $u->setImage($filename);

   */
        $u->setNom($nom);
        $u->setUsername($username);
        $u->setEmail($email);
        $u->setPassword($password);

        $u->setTel($tel);
        $u->setPays($pays);
        $u->setAdd($add);
       // $u->setEtat("not actif");
        $em->persist($u);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($u);
        return new JsonResponse($formatted);

    }


    //    question


    public function listquestAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(question::class)
            ->getquestmob();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }


    public function mobquestAction($h)
    {

        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(question::class)
         //   findOneBy(['quest' => $quest -> getQuest('quest') ,'user' => $user ->getUsername()]);

            ->findquestmob($h);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    public function mobquest2Action($h,$login)
    {

        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(question::class)
            ->findquestmob2($h,$login);

        if($tasks){
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($tasks);
            return new JsonResponse($formatted);

        }
        else{
            $tasks = $this->getDoctrine()->getManager()
                ->getRepository(question::class)
                ->findquestmob($h);

            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($tasks);
            return new JsonResponse($formatted);

        }


    }


    public function ajoutquestmobAction(Request $request, $id,$user,$val, $idval ){
        $em = $this->getDoctrine()->getManager();
        $q2 = $em->getRepository(question::class) ->find($id);

        $verif = $em->getRepository(question::class)  ->findquestmob2($idval,$user);

if($verif){
  //  $u = $em->getRepository(User::class)->find($id);
    // l id mta3 l val eli fil mobile



    $q2->setVal($val);

    $em->persist($q2);
    $em->flush();
    $serializer = new Serializer([new ObjectNormalizer()]);
    $formatted = $serializer->normalize($q2);
    return new JsonResponse($formatted);


//return new Response('m3ebi');
}
else {
  //  return new Response('fera8');


    $q = new question();

    $q->setIdquest($q2->getIdquest());
    $q->setQuest($q2->getQuest());
    $q->setRep($q2->getRep());

    $q->setDate(new \DateTime('now'));
    $q->setUser($user);
    $q->setVal($val);

    $em->persist($q);
    $em->flush();
    $serializer = new Serializer([new ObjectNormalizer()]);
    $formatted = $serializer->normalize($q);
    return new JsonResponse($formatted);





}


    }
}
