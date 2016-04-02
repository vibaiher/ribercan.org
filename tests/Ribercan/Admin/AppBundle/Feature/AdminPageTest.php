<?php

namespace Test\Ribercan\Admin\AppBundle\Feature;

use BladeTester\HandyTestsBundle\Model\HandyTestCase;

class AdminPageTest extends HandyTestCase
{
    function setUp(array $auth = [])
    {
        parent::setUp($auth);
    }

    /**
     * @test
     */
    function showsActionsAvailables()
    {
        $crawler = $this->visit('admin_frontpage');

        $this->assertCount(
            1,
            $crawler->filter('a:contains("Dar de alta un nuevo perro en la protectora")'),
            'Admin page shows a link to add a dog'
        );
        $this->assertCount(
            1,
            $crawler->filter('a:contains("Ver todos los perros de la protectora")'),
            'Admin page shows a link to add a dog'
        );
    }
}
