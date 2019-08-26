<?php

namespace App\Tests\EntityListener;

use App\Entity\Picture;
use App\EntityListener\PictureListener;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\File;

class PictureListenerTest extends TestCase
{
    public function testPrePersist()
    {
        $avatar = $this->createMock(Picture::class);
        $avatar->method('getFile')->willReturn(new File(__DIR__.'/file/base2.png'));
        $avatar->method('getPath')->willReturn(__DIR__.'/file/base2.png');
        $avatarListener = new PictureListener($avatar);
        $this->assertTrue($avatarListener->prePersist($avatar));
    }
}
