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
     * @var
     */
    private $client;

    /**
     * @var
     */
    private $crawler;

    /**
     * Test de connexion avec bon identifiant utilisateur
     */
    public function testGoodAuthentification()
    {
        $this->client = static::createClient();
        $this->login('user5@gmail.com', 'user5');
        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        echo $this->client->getResponse()->getContent();
    }

    /**
     * Test de connexion avec mauvais  identifiant utilisateur
     */
    public function testBadAuthentification()
    {
        $this->client = static::createClient();
        $this->login('badUser@gmail.com', 'badPassword');
        $this->assertSame(1, $this->crawler->filter('html .alert:contains("Identifiants invalides.")')->count());
        echo $this->client->getResponse()->getContent();
    }

    private function login($user, $password)
    {
        $this->crawler = $this->client->request('GET', '/login');
        $this->hydrateForm('Valider', ['_username' => $user, '_password' => $password]);
    }

    /**Remplissage du formulaire
     * @param $button
     * @param $inputs
     */
    private function hydrateForm($button, $inputs)
    {
        $this->crawler = $this->client->submitForm($button, $inputs);
        $this->crawler = $this->client->followRedirect();
    }
}