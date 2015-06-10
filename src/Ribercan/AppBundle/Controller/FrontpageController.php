<?php

namespace Ribercan\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontpageController extends Controller
{
    public function indexAction()
    {
        return $this->render('RibercanAppBundle:Frontpage:index.html.twig');
    }
}
