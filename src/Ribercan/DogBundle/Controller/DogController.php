<?php

namespace Ribercan\DogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ribercan\DogBundle\Form\DogFilterType;

use Ribercan\DogBundle\Model\DogDecorator;

class DogController extends Controller
{
    public function indexAction()
    {
        $dogs = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->findAll();
        $decorated_dogs = array();
        foreach ($dogs as $dog) {
            $decorated_dogs[] = new DogDecorator($dog);
        }

        $filter_form = $this->createForm(DogFilterType::class, array('method' => 'POST'));

        return $this->render('RibercanDogBundle:Dog:index.html.twig', array('dogs' => $decorated_dogs, 'filter_form' => $filter_form->createView()));
    }

    public function showAction($id)
    {
        $dog = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->find($id);
        $decorated_dog = new DogDecorator($dog);

        $limit = 3;
        $urgentAdoptions = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->findUrgentAdoptions($limit);
        $decorated_dogs = array();
        foreach ($urgentAdoptions as $dog) {
            $decorated_dogs[] = new DogDecorator($dog);
        }

        return $this->render(
            'RibercanDogBundle:Dog:show.html.twig',
            array(
                'dog' => $decorated_dog,
                'urgent_adoptions' => $decorated_dogs
            )
        );
    }
}
