<?php


namespace App\Handler;


class TrickHandler extends AbstractHandler
{

    /**
     * Mise à jour d'une figure
     * @throws \Exception
     */
    public function updateTrick()
    {
            $this->entity->setUpdateDate(new \DateTime());
            $this->entityManager->flush();
            $this->flashBag->add('success', 'La figure a bien été modifié');
    }

    /**
     * Ajout d'une nouvelle figure
     * @throws \Exception
     */
    public function addTrick()
    {
        $this->entity->setCreationDate(new \DateTime());
        $this->entity->setUpdateDate(new \DateTime());
        $this->entityManager->persist($this->entity);
        $this->entityManager->flush();
        $this->flashBag->add('success', 'La figure a bien été ajouté');
    }
}