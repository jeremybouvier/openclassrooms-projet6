<?php

namespace App\Handler;


class ChatHandler extends AbstractHandler
{

    public function addChat($trick)
    {
        $this->entity->setUser($this->security->getUser());
        $trick->addChat($this->entity);
        $this->entityManager->flush();
    }
}