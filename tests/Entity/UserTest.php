<?php

namespace App\Tests\Entity;

use App\Entity\Chat;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * test unitaire de la class User
     */
    public function testTrick()
    {
        $user =new User();

        $user->addChat(new Chat());
        $this->assertNotEmpty($user->getChats());

        $user->setToken('test');
        $this->assertSame('test', $user->getToken());

        $this->assertEquals(null, $user->getId());
    }
}
