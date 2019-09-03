<?php

namespace App\Tests\Entity;

use App\Entity\Chat;
use App\Entity\Picture;
use App\Entity\Trick;
use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TrickTest extends TestCase
{
    /**
     * test unitaire de la class Trick
     */
    public function testTrick()
    {
        $trick =new Trick();

        $trick->setCreationDate(new \DateTime());
        $this->assertNotEmpty($trick->getCreationDate());

        $trick->addChat(new Chat());
        $this->assertNotEmpty($trick->getChats());

        $trick->addVideo(new Video());
        $this->assertNotEmpty($trick->getVideos());

        $trick->addPicture(new Picture());
        $this->assertNotEmpty($trick->getPictures());
    }
}
