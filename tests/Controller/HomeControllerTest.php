<?php

namespace App\Tests\controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /**
     * test de la redirection vers la home page
     */
    public function testHomepageIsUp()
    {

        $client = static::createClient();
        $client->request('GET', '/');
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
