<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 17/08/19
 * Time: 14:44
 */

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageConnexionTest extends WebTestCase
{
    /**
     * @dataProvider provideRoute
     */
    public function testPageStatus($route)
    {
        $client = static::createClient();
        $client->request('GET', $route);
        $this->assertSame(200, $client->getResponse()->getStatusCode(), 'Mauvais statuts sur la route'.$route);
    }

    public function provideRoute()
    {
        return [
            ['/login'],
            ['/Liste-des-figures'],
            ['/Figures/2/1'],
            ['/Enregistrement-Nouveau-Membre'],
        ];
    }
}