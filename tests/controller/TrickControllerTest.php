<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 17/08/19
 * Time: 14:50
 */

namespace App\Tests\controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TrickControllerTest extends WebTestCase
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
     * Test de l'ajout d'un message sur l'espace de discussion
     */
    public function testAddMessage()
    {
        $this->client = static::createClient();

        $this->crawler = $this->client->request('GET', '/login');
        $this->userConnexion('user5@gmail.com', 'user5');

        $this->crawler = $this->client->request('GET', '/Figures/2/1');
        $this->hydrateForm('Poster le message', ['chat[message]'=>'test message1']);

        $this->assertSame(1, $this->crawler->filter('html:contains("test message1")')->count());
    }

    public function testAddTrick()
    {
        $this->client = static::createClient();

        $this->crawler = $this->client->request('GET', '/login');
        $this->userConnexion('user5@gmail.com', 'user5');

        $link = $this->crawler->selectLink('html:contains("Ajouter une figure")')->link();
        $this->client->click($link);
        $this->crawler= $this->client->followRedirect();
        $this->client->getResponse()->getContent();
    }

    /**
     * Connexion de l'utilisateur
     * @param $user
     * @param $password
     */
    private function userConnexion($user, $password)
    {
        $this->crawler = $this->client->submitForm('Valider', [
            '_username' => $user,
            '_password' => $password
        ]);
        $this->crawler= $this->client->followRedirect();
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
