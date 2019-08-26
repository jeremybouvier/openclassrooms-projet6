<?php

namespace App\Tests\Repository;

use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VideoRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Test du Video repository
     */
    public function testFindAll()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $video = $this->entityManager
            ->getRepository(Video::class)
            ->count(['id'=>1]);
        ;

        $this->assertEquals(1, $video);
    }
}
