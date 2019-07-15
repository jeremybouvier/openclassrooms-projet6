<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 08/07/19
 * Time: 20:59
 */

namespace App\EntityListener;


use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HashPasswordListener implements EventSubscriber
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist','preUpdate'];
    }

    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $user = $eventArgs->getEntity();
        if (!$user instanceof User) {
            return;
        }

        $user->setPassword($this->encodedPassword($user));
    }

    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $user = $eventArgs->getEntity();
        if (!$user instanceof User) {
            return;
        }

        if (!$user->getPlainPassword()) {
            return;
        }

        $user->setPassword($this->encodedPassword($user));
    }

    private function encodedPassword($user)
    {
        return $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
    }

}