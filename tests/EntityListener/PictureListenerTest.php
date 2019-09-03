<?php

namespace App\Tests\EntityListener;

use App\Entity\Picture;
use App\EntityListener\PictureListener;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureListenerTest extends TestCase
{
    private $path;
    /**
     * test de téléchargement d'une image
     */
    public function testPrePersist()
    {
        $picture = new Picture();
        $picture->setFile($this->createFile());
        $pictureListener = new PictureListener($picture);
        $this->assertTrue($pictureListener->prePersist($picture));
        $picture = new Picture();
        $this->assertEquals(null, $pictureListener->prePersist($picture));
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
            __DIR__.'/../../public/assets/image'.$filename
        );
        $this->path = __DIR__.'/../../public/assets/image'.$filename;
        return new UploadedFile(__DIR__.'/../../public/assets/image'.$filename, $filename, 'image/png', null, true);
    }
}
