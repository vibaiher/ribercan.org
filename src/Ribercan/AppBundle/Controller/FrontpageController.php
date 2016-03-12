<?php

namespace Ribercan\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontpageController extends Controller
{
    public function indexAction()
    {
        $urgentAdoptions = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->findUrgentAdoptions();

        return $this->render('RibercanAppBundle:Frontpage:index.html.twig', array('urgent_adoptions' => $urgentAdoptions));
    }
}
