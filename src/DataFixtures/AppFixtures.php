<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstname('user'.$i);
            $user->setSurname('user'.$i);
            $user->setEmail('user'.$i.'@gmail.com');
            $user->setLoginName('user'.$i);
            $user->setPlainPassword('user'.$i);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
