<?php

namespace Ribercan\HowToHelpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RibercanHowToHelpBundle:Default:index.html.twig');
    }
}
