<?php

namespace App\Tests\EntityListener;

use App\Entity\Avatar;
use App\EntityListener\AvatarListener;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AvatarListenerTest extends TestCase
{
    /**
     * test de téléchargement d'une image
     */
    public function testPrePersist()
    {
        $avatar = new Avatar();
        $avatar->setFile($this->createFile());
        $avatarListener = new AvatarListener($avatar);
        $this->assertTrue($avatarListener->prePersist($avatar));
        $avatar = new Avatar();
        $this->assertEquals(null, $avatarListener->prePersist($avatar));
    }

    /**
     * création du fichier test
     * @return UploadedFile
     */
    private function createFile(): UploadedFile
    {
        $filename = md5(uniqid('', true)).'.png';
        copy(
            __DIR__.'/../../public/assets/image/base.png',
            __DIR__.'/file/'.$filename
        );
        return new UploadedFile(__DIR__.'/file/'.$filename, $filename, 'image/png', null, true);
    }
}
