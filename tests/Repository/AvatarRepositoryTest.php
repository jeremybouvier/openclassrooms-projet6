<?php

namespace App\Tests\Repository;

use App\Entity\Avatar;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AvatarRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Test du Avatar repository
     */
    public function testFindAll()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $avatar = $this->entityManager
            ->getRepository(Avatar::class)
            ->count(['id'=>1]);
        ;

        $this->assertEquals(1, $avatar);
    }
}
