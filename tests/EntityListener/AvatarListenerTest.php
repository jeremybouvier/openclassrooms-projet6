<?php

namespace App\Tests\EntityListener;

use App\Entity\Avatar;
use App\EntityListener\AvatarListener;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\File;

class AvatarListenerTest extends TestCase
{
    public function testPrePersist()
    {
        $avatar = $this->createMock(Avatar::class);
        $avatar->method('getFile')->willReturn(new File(__DIR__.'/file/base1.png'));
        $avatar->method('getPath')->willReturn(__DIR__.'/file/base1.png');
        $avatarListener = new AvatarListener($avatar);
        $this->assertTrue($avatarListener->prePersist($avatar));
    }
}
