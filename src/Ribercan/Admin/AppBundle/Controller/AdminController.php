<?php

namespace Ribercan\Admin\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Admin controller.
 */
class AdminController extends Controller
{

    /**
     * Lists all admin actions availables.
     *
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
