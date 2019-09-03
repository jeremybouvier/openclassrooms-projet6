<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

trait AuthenticationTrait
{
    /**
     * @var User
     */
    private $user;

    /**
     * Crée un utilisateur authentifié
     * @param string $email
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    public function createAuthenticatedClient(string $email = 'user0@gmail.com')
    {
        $client = static::createClient();

        $session = $client->getContainer()->get('session');
        $doctrine = $client->getContainer()->get('doctrine.orm.entity_manager');

        $firewallName = 'main';
        $firewallContext = 'main';

        $this->user = $doctrine->getRepository(User::class)->findOneByEmail($email);

        $token = new UsernamePasswordToken($this->user, null, $firewallName, $this->user->getRoles());
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        return $client;
    }
}
