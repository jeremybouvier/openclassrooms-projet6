<?php

namespace App\Handler;

use App\Form\ChatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ChatHandler extends AbstractHandler
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * TrickHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * Donne le type de formulaire
     * @return string
     */
    protected static function getFormType(): string
    {
        return ChatType::class;
    }

    /**
     * effectue le le traitement de l'ajout d'un message
     * @param null $param
     */
    protected function process($param = null): void
    {
        $this->data->setUser($this->security->getUser());
        $param->addChat($this->data);
        $this->entityManager->flush();
    }
}
