<?php

namespace Ribercan\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ribercan\DogBundle\Form\DogFilterType;
use Ribercan\DogBundle\Model\DogDecorator;

class FrontpageController extends Controller
{
    const LATEST_NEWS_LIMIT = 4;
    const URGENT_ADOPTIONS_LIMIT = null;

    public function indexAction()
    {
        $filterForm = $this->createForm(
            DogFilterType::class,
            null,
            array(
                'action' => $this->generateUrl('dogs_in_adoption'),
                'method' => 'POST'
            )
        );

        $urgentAdoptions = $this->get('doctrine')->
            getRepository('RibercanAdminDogBundle:Dog')->
            findUrgentAdoptions(self::URGENT_ADOPTIONS_LIMIT);

        $decorated_dogs = array();
        foreach ($urgentAdoptions as $dog) {
            $decorated_dogs[] = new DogDecorator($dog);
        }

        $news = $this->get('doctrine')->
            getRepository('RibercanNewsBundle:Announcement')->
            findLatestNews(self::LATEST_NEWS_LIMIT);

        return $this->render(
            'RibercanAppBundle:Frontpage:index.html.twig',
            array(
                'filterForm' => $filterForm->createView(),
                'urgent_adoptions' => $decorated_dogs,
                'news' => $news
            )
        );
    }
}
