<?php

namespace Ribercan\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ribercan\DogBundle\Form\DogFilterType;
use Ribercan\DogBundle\Model\DogDecorator;

class FrontpageController extends Controller
{
    public function indexAction()
    {
        $filterForm = $this->createForm(
            DogFilterType::class,
            null,
            array(
                'action' => $this->generateUrl('dogs_in_adoption'),
                'method' => 'POST'
            )
        );
        $urgentAdoptions = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->findUrgentAdoptions();
        $decorated_dogs = array();
        foreach ($urgentAdoptions as $dog) {
            $decorated_dogs[] = new DogDecorator($dog);
        }

        return $this->render(
            'RibercanAppBundle:Frontpage:index.html.twig',
            array(
                'filterForm' => $filterForm->createView(),
                'urgent_adoptions' => $decorated_dogs
            )
        );
    }
}
