<?php

namespace sponsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('sponsBundle:Default:index.html.twig');
    }
}
