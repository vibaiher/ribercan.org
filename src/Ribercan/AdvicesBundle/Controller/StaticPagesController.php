<?php

namespace Ribercan\AdvicesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticPagesController extends Controller
{
    public function advicesAction()
    {
        return $this->render(
            'RibercanAdvicesBundle:StaticPages:advices.html.twig'
        );
    }

    public function chipAction()
    {
        return $this->render(
            'RibercanAdvicesBundle:StaticPages:chip.html.twig'
        );
    }

    public function adoptantGuideAction()
    {
        return $this->render(
            'RibercanAdvicesBundle:StaticPages:adoptant_guide.html.twig'
        );
    }

    public function leishmaniaAction()
    {
        return $this->render(
            'RibercanAdvicesBundle:StaticPages:leishmania.html.twig'
        );
    }

    public function dogsAndKidsAction()
    {
        return $this->render(
            'RibercanAdvicesBundle:StaticPages:dogs_and_kids.html.twig'
        );
    }

    public function dogsAndCatsAction()
    {
        return $this->render(
            'RibercanAdvicesBundle:StaticPages:dogs_and_cats.html.twig'
        );
    }

    public function foundDogAction()
    {
        return $this->render(
            'RibercanAdvicesBundle:StaticPages:found_dog.html.twig'
        );
    }

    public function heatstrokeAction()
    {
        return $this->render(
            'RibercanAdvicesBundle:StaticPages:heatstroke.html.twig'
        );
    }

    public function lostPetAction()
    {
        return $this->render(
            'RibercanAdvicesBundle:StaticPages:lost_pet.html.twig'
        );
    }
}
