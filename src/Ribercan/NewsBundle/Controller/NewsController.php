<?php

namespace Ribercan\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {
        $news = $this->get('doctrine')->
            getRepository('RibercanNewsBundle:Announcement')
            ->findAllWithNewestFirst();

        return $this->render(
            'RibercanNewsBundle:News:index.html.twig',
            array('news' => $news)
        );
    }

    public function showAction($id)
    {
        $announcement = $this->get('doctrine')->
            getRepository('RibercanNewsBundle:Announcement')
            ->find($id);

        return $this->render(
            'RibercanNewsBundle:News:show.html.twig',
            array(
                'announcement' => $announcement,
                'image' => $announcement->getImage()
            )
        );
    }
}
