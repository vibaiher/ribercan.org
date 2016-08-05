<?php

namespace Ribercan\AboutUsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticPagesController extends Controller
{
    public function aboutUsAction()
    {
        return $this->render(
            'RibercanAboutUsBundle:StaticPages:about_us.html.twig'
        );
    }

    public function contactsAction()
    {
        return $this->render(
            'RibercanAboutUsBundle:StaticPages:contacts.html.twig'
        );
    }

    public function forReginaAction()
    {
        return $this->render(
            'RibercanAboutUsBundle:StaticPages:for_regina.html.twig'
        );
    }

    public function ribercanFriendsAction()
    {
        return $this->render(
            'RibercanAboutUsBundle:StaticPages:ribercan_friends.html.twig'
        );
    }
}
