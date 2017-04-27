<?php

namespace Ribercan\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'RibercanEventBundle:Event:index.html.twig'
        );
    }

    public function fetchAction()
    {
        $events = $this->findAllComing();

        return new JsonResponse(
            array(
                'events' => $events
            )
        );
    }

    private function findAllComing()
    {
        $all = [
          array('name' => 'Event One'),
          array('name' => 'Event Two'),
          array('name' => 'Event Three')
        ];

        return $all;
    }
}
