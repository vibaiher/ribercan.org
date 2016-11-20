<?php

namespace Ribercan\Admin\NewsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $delete_form = $this->createDeleteForm($announcement);

        return $this->render(
            'RibercanAdminNewsBundle:News:show.html.twig',
            array(
                'announcement'  => $announcement,
                'delete_form' => $delete_form->createView()
            )
        );
    }

    public function editAction(Request $request, Announcement $announcement)
    {
        $editForm = $this->createForm(AnnouncementType::class, $announcement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($announcement);
            $entityManager->flush();

            return $this->redirectToRoute('admin_announcement_show', array('id' => $announcement->getId()));
        }

        return $this->render(
            'RibercanAdminNewsBundle:News:edit.html.twig',
            array(
                'announcement' => $announcement,
                'edit_form' => $editForm->createView()
            )
        );
    }

    public function deleteAction(Request $request, Announcement $announcement)
    {
        $form = $this->createDeleteForm($announcement);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($announcement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_news_index');
    }

    private function createDeleteForm(Announcement $announcement)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'admin_announcement_delete',
                    array(
                        'id' => $announcement->getId()
                    )
                )
            )
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
