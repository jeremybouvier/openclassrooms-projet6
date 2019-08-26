<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageConnexionTest extends WebTestCase
{
    /**
     * test du bon staus de chaque page du site
     * @dataProvider provideRoute
     */
    public function testPageStatus($route)
    {
        $client = static::createClient();
        $client->request('GET', $route);
        $this->assertSame(200, $client->getResponse()->getStatusCode(), 'Mauvais statuts sur la route'.$route);
    }

    /**
     * Fourni les données des routes
     * @return array
     */
    public function provideRoute()
    {
        return [
            ['/login'],
            ['/liste-des-figures'],
            ['/figure/2'],
            ['/enregistrement-nouveau-membre'],
        ];
    }
}
