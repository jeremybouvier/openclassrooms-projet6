<?php

namespace App\Tests\Entity;

use App\Entity\Avatar;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\File;

class AvatarTestn extends TestCase
{
    /**
     * test unitaire de la class Avatar
     */
    public function testTrick()
    {
        $avatar =new Avatar();

        $avatar->setFile(new File(__DIR__.'/base.png'));
        $this->assertNotEmpty($avatar->getFile());


        $this->assertEquals(null, $avatar->getId());
    }
}
