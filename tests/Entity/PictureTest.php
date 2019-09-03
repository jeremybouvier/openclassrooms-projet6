<?php

namespace App\Tests\Entity;

use App\Entity\Picture;
use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PictureTest extends TestCase
{
    /**
     * test unitaire de la class Picture
     */
    public function testPicture()
    {
        $picture =new Picture();
        $picture->setPath('test');
        $this->assertSame('test', $picture->getPath());
        $picture->setTrick(new Trick());
        $this->assertNotEmpty($picture->getTrick());
        $picture->setFile(__DIR__.'/base.png');
        $this->assertNotEmpty($picture->getFile());
        $this->assertEquals(null, $picture->getId());
    }
}
