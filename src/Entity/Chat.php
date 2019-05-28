<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatRepository")
 */
class Chat
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
    private $chatText;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userId")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\trick", inversedBy="chats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trickId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChatText(): ?string
    {
        return $this->chatText;
    }

    public function setChatText(string $chatText): self
    {
        $this->chatText = $chatText;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->userId;
    }

    public function setUserId(?user $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getTrickId(): ?trick
    {
        return $this->trickId;
    }

    public function setTrickId(?trick $trickId): self
    {
        $this->trickId = $trickId;

        return $this;
    }
}
