<?php

namespace App\Tests\Entity;

use App\Entity\Trick;
use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class VideoTest extends TestCase
{
    /**
     * test unitaire de la class Video
     */
    public function testVideo()
    {
        $video =new Video();
        $video->setPath('test');
        $this->assertSame('test', $video->getPath());
        $video->setTrick(new Trick());
        $this->assertNotEmpty($video->getTrick());
        $this->assertEquals(null, $video->getId());
    }
}
