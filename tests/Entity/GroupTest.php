<?php

namespace App\Tests;

use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class GroupTest extends TestCase
{

    /**
     * test unitaire de la class Group
     */
    public function testGroup()
    {
        $group =new Group();
        $group->setName('test');
        $this->assertSame('test', $group->getName());
        $group->addTrick(new Trick());
        $this->assertNotEmpty($group->getTrick());
        $this->assertEquals(null, $group->getId());
    }
}
