<?php

namespace eventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('eventBundle:Default:index.html.twig');
    }
}
