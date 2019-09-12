<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    /**
     * test de l'ajout d'un utilisateur
     */
    public function testAddUser()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/enregistrement-nouveau-membre');

        $client->submitForm('Valider', [
            'user[loginName]' => 'testuser',
            'user[email]' => 'test@email.com',
            'user[plainPassword]' => 'testPassword'
        ]);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(
            1,
            $crawler->filter('html:contains("Votre enregistrement a bien été effectué")')->count()
        );
    }

    /**
     * test de la requète de l'envoi d'un nouveau mot de passe
     */
    public function testInitPasswordUser()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/oubli-mot-de-passe');

        $client->submitForm('Valider', [
            'user[loginName]' => 'user0',
        ]);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
