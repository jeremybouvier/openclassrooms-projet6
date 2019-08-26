<?php

namespace App\Tests\Repository;

use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PictureRepositoryTest extends  KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Test du Picture repository
     */
    public function testFindAll()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $picture = $this->entityManager
            ->getRepository(Picture::class)
            ->count(['id'=>1]);
        ;

        $this->assertEquals(1, $picture);
    }
}
