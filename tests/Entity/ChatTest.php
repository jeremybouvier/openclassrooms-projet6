<?php

namespace App\Tests\Entity;

use App\Entity\Chat;
use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ChatTest extends TestCase
{
    /**
     * test unitaire de la class Chat
     */
    public function testTrick()
    {
        $chat =new Chat();

        $chat->setDate(new \DateTime());
        $this->assertNotEmpty($chat->getDate());

        $chat->setTrick(new Trick());
        $this->assertNotEmpty($chat->getTrick());

        $this->assertEquals(null, $chat->getId());
    }
}
