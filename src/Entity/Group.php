<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 */
class Group
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="groupId")
     */
    private $groupId;

    public function __construct()
    {
        $this->groupId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Trick[]
     */
    public function getGroupId(): Collection
    {
        return $this->groupId;
    }

    public function addGroupId(Trick $groupId): self
    {
        if (!$this->groupId->contains($groupId)) {
            $this->groupId[] = $groupId;
            $groupId->setGroupId($this);
        }

        return $this;
    }

    public function removeGroupId(Trick $groupId): self
    {
        if ($this->groupId->contains($groupId)) {
            $this->groupId->removeElement($groupId);
            // set the owning side to null (unless already changed)
            if ($groupId->getGroupId() === $this) {
                $groupId->setGroupId(null);
            }
        }

        return $this;
    }
}
