<?php

namespace Ribercan\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopController extends Controller
{
    public function indexAction()
    {
        $availableProducts = $this->get('doctrine')->
            getRepository('RibercanShopBundle:Product')->
            findBy(array('available' => true));

        return $this->render(
            'RibercanShopBundle:Shop:index.html.twig',
            array('products' => $availableProducts)
        );
    }
}
