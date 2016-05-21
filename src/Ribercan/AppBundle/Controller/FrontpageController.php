<?php

namespace Ribercan\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ribercan\DogBundle\Model\DogDecorator;

class FrontpageController extends Controller
{
    public function indexAction()
    {
        $urgentAdoptions = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->findUrgentAdoptions();
        $decorated_dogs = array();
        foreach ($urgentAdoptions as $dog) {
            $decorated_dogs[] = new DogDecorator($dog);
        }

        return $this->render('RibercanAppBundle:Frontpage:index.html.twig', array('urgent_adoptions' => $decorated_dogs));
    }
}
