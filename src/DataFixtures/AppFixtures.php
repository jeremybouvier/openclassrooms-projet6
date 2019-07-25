<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Modèle de construction de données utilisateurs en base de donnée
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setLoginName('user'.$i);
            $user->setEmail('user'.$i.'@gmail.com');
            $avatar = new Avatar();
            $avatar->setPath('/assets/image/avatar/base.jpg');
            $user->setAvatar($avatar);
            $user->setPlainPassword('user'.$i);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
