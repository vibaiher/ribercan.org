<?php

namespace Ribercan\DogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ribercan\Admin\DogBundle\Entity\Dog;
use Ribercan\DogBundle\Model\DogDecorator;

use Symfony\Component\HttpFoundation\Request;
use Ribercan\DogBundle\Form\DogFilterType;

class DogController extends Controller
{
    const URGENT_ADOPTIONS_LIMIT = 3;

    public function indexAction(Request $request)
    {
        $filterForm = $this->createForm(
            DogFilterType::class,
            null,
            array(
                'method' => 'POST'
            )
        );
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $dogs = $this->get('dog.filter')->filterBy($filterForm->getData());
        }
        else {
            $dogs = $this->findDogs();
        }

        return $this->render(
            'RibercanDogBundle:Dog:index.html.twig',
            array(
                'dogs' => $this->decorateDogs($dogs),
                'filterForm' => $filterForm->createView()
            )
        );
    }

    public function showAction($id)
    {
        $dog = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->find($id);
        $urgentAdoptions = $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog')->findUrgentAdoptions(DogController::URGENT_ADOPTIONS_LIMIT);

        return $this->render(
            'RibercanDogBundle:Dog:show.html.twig',
            array(
                'dog' => $this->decorateDog($dog),
                'urgent_adoptions' => $this->decorateDogs($urgentAdoptions)
            )
        );
    }

    private function decorateDogs(Array $dogs)
    {
        $decoratedDogs = array();

        foreach ($dogs as $dog) {
            $decoratedDogs[] = $this->decorateDog($dog);
        }

        return $decoratedDogs;
    }

    private function decorateDog(Dog $dog)
    {
        return new DogDecorator($dog);
    }

    private function findDogs()
    {
        return $this->repository()->findAll();
    }

    private function repository()
    {
        return $this->get('doctrine')->getRepository('RibercanAdminDogBundle:Dog');
    }
}
