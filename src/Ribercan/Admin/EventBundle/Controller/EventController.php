<?php

namespace Ribercan\Admin\EventBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ribercan\EventBundle\Entity\Event;
use Ribercan\Admin\EventBundle\Form\EventType;

class EventController extends Controller
{
    public function indexAction()
    {
        $events = $this->get('doctrine')->
            getRepository('RibercanEventBundle:Event')
            ->findAll();
        return $this->render(
            'RibercanAdminEventBundle:Event:index.html.twig',
            array('events' => $events)
        );
    }

    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute(
                'admin_event_show',
                array(
                    'id' => $event->getId()
                )
            );
        }

        return $this->render(
            'RibercanAdminEventBundle:Event:new.html.twig',
            array(
                'event' => $event,
                'form' => $form->createView(),
            )
        );
    }

    public function showAction(Event $event)
    {
        $delete_form = $this->createDeleteForm($event);

        return $this->render(
            'RibercanAdminEventBundle:Event:show.html.twig',
            array(
                'event'  => $event,
                'delete_form' => $delete_form->createView()
            )
        );
    }

    public function editAction(Request $request, Event $event)
    {
        $editForm = $this->createForm(EventType::class, $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('admin_event_show', array('id' => $event->getId()));
        }

        return $this->render(
            'RibercanAdminEventBundle:Event:edit.html.twig',
            array(
                'event' => $event,
                'edit_form' => $editForm->createView()
            )
        );
    }

    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_events_index');
    }

    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'admin_event_delete',
                    array(
                        'id' => $event->getId()
                    )
                )
            )
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
