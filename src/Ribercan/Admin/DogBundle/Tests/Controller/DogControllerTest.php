<?php

namespace Ribercan\Admin\DogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DogControllerTest extends WebTestCase
{
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/admin/dog/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/dog/");
        $crawler = $client->click($crawler->selectLink('Añadir perro en adopción')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'ribercan_admin_dogbundle_dog[name]'  => 'Test',
            'ribercan_admin_dogbundle_dog[sex]'  => 0,
            'ribercan_admin_dogbundle_dog[birthday]'  => array(
                'year' => 2010,
                'month' => 1,
                'day' => 1
            ),
            'ribercan_admin_dogbundle_dog[joinDate]'  => array(
                'year' => 2010,
                'month' => 1,
                'day' => 1
            ),
            'ribercan_admin_dogbundle_dog[health]'  => 0,
            'ribercan_admin_dogbundle_dog[godfather]'  => '',
            'ribercan_admin_dogbundle_dog[description]'  => 'Custom description',
            'ribercan_admin_dogbundle_dog[size]'  => 0,
            'ribercan_admin_dogbundle_dog[urgent]'  => false
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'ribercan_admin_dogbundle_dog[name]'  => 'Foo',
            'ribercan_admin_dogbundle_dog[urgent]'  => true
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }
}
