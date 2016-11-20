<?php

namespace Ribercan\Admin\NewsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ribercan\NewsBundle\Entity\Announcement;
use Ribercan\Admin\NewsBundle\Form\AnnouncementType;

class NewsController extends Controller
{
    public function indexAction()
    {
        $news = $this->get('doctrine')->
            getRepository('RibercanNewsBundle:Announcement')
            ->findAll();
        return $this->render(
            'RibercanAdminNewsBundle:News:index.html.twig',
            array('news' => $news)
        );
    }

    public function newAction(Request $request)
    {
        $announcement = new Announcement();
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($announcement);
            $entityManager->flush();

            return $this->redirectToRoute(
                'admin_announcement_show',
                array(
                    'id' => $announcement->getId()
                )
            );
        }

        return $this->render(
            'RibercanAdminNewsBundle:News:new.html.twig',
            array(
                'announcement' => $announcement,
                'form' => $form->createView(),
            )
        );
    }

    public function showAction(Announcement $announcement)
    {
        return $this->render(
            'RibercanAdminNewsBundle:News:show.html.twig',
            array(
                'announcement'  => $announcement
            )
        );
    }
}
