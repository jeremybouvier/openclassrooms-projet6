<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 17/08/19
 * Time: 13:51
 */

namespace App\Tests\controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControlleurTest extends WebTestCase
{
    /**
     * Test de connexion avec bon identifiant utilisateur
     */
    public function testGoodAuthentification()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->submitForm('Valider', [
            '_username' => 'user5@gmail.com',
            '_password' => 'user5'
        ]);
        $crawler = $client->followRedirect();
        $this->assertSame(302, $client->getResponse()->getStatusCode(), "echec de l'authentification");
        echo $client->getResponse()->getContent();
    }

    /**
     * Test de connexion avec mauvais  identifiant utilisateur
     */
    public function testBadAuthentification()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $crawler = $client->submitForm('Valider', [
            '_username' => 'toto@gmail.com',
            '_password' => 'test'
        ]);
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('html .alert:contains("Identifiants invalides.")')->count());
        echo $client->getResponse()->getContent();
    }
}