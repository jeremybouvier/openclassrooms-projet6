<?php

namespace App\Handler;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class UserHandler extends AbstractHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * TrickHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param FlashBagInterface $flashBag
     */
    public function __construct(EntityManagerInterface $entityManager, FlashBagInterface $flashBag)
    {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
    }

    /**
     * Donne le type de formulaire
     * @return string
     */
    protected static function getFormType(): string
    {
        return UserType::class;
    }

    /**
     * @param null $param
     */
    protected function process($param = null): void
    {
        if ($this->entityManager->getUnitOfWork()->getEntityState($this->data) === UnitOfWork::STATE_NEW) {
            $this->flashBag->add('success', 'Votre enregistrement a bien été effectué');
            $this->entityManager->persist($this->data);
        } else {
            $this->data->setToken('');
            $this->entityManager->persist($this->data);
        }

        $this->entityManager->flush();
    }
}
