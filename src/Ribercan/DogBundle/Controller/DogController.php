<?php

namespace Ribercan\DogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DogController extends Controller
{
    public function indexAction()
    {
        $dogs = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->findAll();

        return $this->render('RibercanDogBundle:Dog:index.html.twig', array('dogs' => $dogs));
    }

    public function showAction($id)
    {
        $dog = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->find($id);

        return $this->render('RibercanDogBundle:Dog:show.html.twig', array('dog' => $dog));
    }
}
