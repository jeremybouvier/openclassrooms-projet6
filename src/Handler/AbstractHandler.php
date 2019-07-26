<?php

namespace App\Handler;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Security;

abstract class AbstractHandler
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var Security
     */
    protected $security;

    /**
     * @var FlashBagInterface
     */
    protected $flashBag;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var
     */
    protected $entity;

    /**
     * AbstractHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param FormFactoryInterface $formFactory
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, Security $security, FlashBagInterface $flashBag)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->security = $security;
        $this->flashBag = $flashBag;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Création du formulaire
     * @param string $entityType
     * @param null $entity
     * @return AbstractHandler
     */
    public function createForm(string $entityType, $entity = null): self
    {
        $this->entity = $entity;
        $this->form = $this->formFactory->create($entityType, $this->entity);
        return $this;
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request): void
    {
        $this->form->handleRequest($request);
    }

    /**
     * Verification de la soumission et de la validité du formulaire
     * @return bool
     */
    public function isFormValid(): bool
    {
        return ($this->form->isSubmitted() && $this->form->isValid());
    }

    /**
     * Création de la vue du formulaire
     * @return FormView
     */
    public function createView(): FormView
    {
        return $this->form->createView();
    }

}