<?php

namespace Ribercan\HowToHelpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticPagesController extends Controller
{
    public function howToHelpAction()
    {
        return $this->render(
            'RibercanHowToHelpBundle:StaticPages:how_to_help.html.twig'
        );
    }

    public function adoptAction()
    {
        return $this->render(
            'RibercanHowToHelpBundle:StaticPages:adopt.html.twig'
        );
    }

    public function takeInAction()
    {
        return $this->render(
            'RibercanHowToHelpBundle:StaticPages:take_in.html.twig'
        );
    }

    public function beOurPartnerAction()
    {
        return $this->render(
            'RibercanHowToHelpBundle:StaticPages:be_our_partner.html.twig'
        );
    }

    public function beVolunteerAction()
    {
        return $this->render(
            'RibercanHowToHelpBundle:StaticPages:be_volunteer.html.twig'
        );
    }

    public function godfatherAction()
    {
        return $this->render(
            'RibercanHowToHelpBundle:StaticPages:godfather.html.twig'
        );
    }

    public function donateMaterialAction()
    {
        return $this->render(
            'RibercanHowToHelpBundle:StaticPages:donate_material.html.twig'
        );
    }

    public function donateAction()
    {
        return $this->render(
            'RibercanHowToHelpBundle:StaticPages:donate.html.twig'
        );
    }

    public function teamingGroupAction()
    {
        return $this->render(
            'RibercanHowToHelpBundle:StaticPages:teaming_group.html.twig'
        );
    }
}
