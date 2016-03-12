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
        $filter_form = $this->createForm(DogFilterType::class, array('method' => 'POST'));

        return $this->render('RibercanDogBundle:Dog:index.html.twig', array('dogs' => $dogs, 'filter_form' => $filter_form->createView()));
    }

    public function showAction($id)
    {
        $dog = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->find($id);
        $dog_decorator = new DogDecorator($dog);

        $limit = 3;
        $urgentAdoptions = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->findUrgentAdoptions($limit);

        return $this->render(
            'RibercanDogBundle:Dog:show.html.twig',
            array(
                'dog' => $dog_decorator,
                'urgent_adoptions' => $urgentAdoptions
            )
        );
    }
}
