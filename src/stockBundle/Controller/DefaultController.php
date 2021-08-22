<?php

namespace stockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('stockBundle:Default:index.html.twig');
    }
}
