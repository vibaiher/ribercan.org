<?php

namespace Ribercan\DogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DogController extends Controller
{
    public function indexAction()
    {
        return $this->render('RibercanDogBundle:Dog:index.html.twig', array());
    }
}
