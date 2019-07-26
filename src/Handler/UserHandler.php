<?php

namespace App\Handler;


class UserHandler extends AbstractHandler
{

    /**
     *
     */
    public function addUser()
    {
        $this->entityManager->persist($this->entity);
        $this->entityManager->flush();
        $this->flashBag->add('success', 'Votre enregistrement a bien été effectué');
    }
}