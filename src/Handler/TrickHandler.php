<?php

namespace App\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use App\Form\TrickType;

class TrickHandler extends AbstractHandler
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
        return TrickType::class;
    }

    /**
     * Effectue le traitement de creation ou de modification d'une figure
     * @param null $param
     * @throws \Exception
     */
    protected function process($param = null): void
    {
        if ($this->entityManager->getUnitOfWork()->getEntityState($this->data) === UnitOfWork::STATE_NEW) {
            $this->entityManager->persist($this->data);
            $this->flashBag->add('success', 'La figure a bien été ajoutée');
        } else {
            $this->data->setUpdateDate(new \DateTime());
            $this->flashBag->add('success', 'La figure a bien été modifiée');
        }
        $this->entityManager->flush();
    }
}
