<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 14/08/19
 * Time: 22:30
 */

namespace App\Tests\controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomepageIsUp()
    {

        $client = static::createClient();
        $client->request('GET', '/');
        $client->followRedirect();
        echo $client->getResponse()->getContent();
    }

}