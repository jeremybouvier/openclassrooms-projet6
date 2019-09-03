<?php

namespace App\Tests\controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\AuthenticationTrait;

class TrickControllerTest extends WebTestCase
{
    use AuthenticationTrait;

    /**
     * test de l'ajout d'un message
     */
    public function testAddMessage()
    {
        $client = $this->createAuthenticatedClient();

        $crawler = $client->request('GET', '/figure/2/1');
        $client->submitForm('Poster le message', ['chat[message]'=>'test message1']);
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("test message1")')->count());
    }

    /**
     * test de l'ajout d'une figure
     */
    public function testAddTrick()
    {
        $client = $this->createAuthenticatedClient();

        $crawler = $client->request('GET', '/membre/ajout-figure');
        $client->submitForm('Enregistrer les modifications', [
            'trick[name]'=>'test name',
            'trick[description]'=>'test description',
            'trick[group]'=>1
        ]);
        $crawler= $client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("La figure a bien été ajoutée")')->count());
    }

    /**
     * test de la mise à jour d'une figure
     */
    public function testUpdateTrick()
    {
        $client = $this->createAuthenticatedClient();

        $crawler = $client->request('GET', '/membre/edition-figure/4');
        $client->submitForm('Enregistrer les modifications', [
            'trick[name]'=>'update name',
            'trick[description]'=>' update description',
        ]);
        $crawler= $client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("La figure a bien été modifiée")')->count());
    }

    /**
     * test de la suppression d'une figure
     */
    public function testDeleteTrick()
    {
        $client = $this->createAuthenticatedClient();

        $crawler = $client->request('GET', '/membre/edition-figure/4');

        $client->submit($crawler->filter('form[name="formDelete"]')->form([], 'DELETE'));

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
