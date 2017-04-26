<?php

namespace Ribercan\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class EventController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'RibercanEventBundle:Event:index.html.twig',
            array(
              'events' => $this->findAll()
            )
        );
    }

    public function showAction($id)
    {
        return $this->render(
            'RibercanEventBundle:Event:show.html.twig',
            array(
                'event' => $this->find($id)
            )
        );
    }

    private function findAll()
    {
        $events = $this->get('doctrine')->
            getRepository('RibercanEventBundle:Event')
            ->findAllWithNewestFirst();

        return $events;
    }

    private function find($reference)
    {
        $event = $this->get('doctrine')->
            getRepository('RibercanEventBundle:Event')
            ->find($reference);

        return $event;
    }
}
