<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Length(max = 255, maxMessage = "Le message ne doit pas excéder 255 charatères")
     * @Assert\NotBlank
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="chats",cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="chats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    /**
     * Chat constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Chat
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return Chat
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return user|null
     */
    public function getUser(): ?user
    {
        return $this->user;
    }

    /**
     * @param user|null $user
     * @return Chat
     */
    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return trick|null
     */
    public function getTrick(): ?trick
    {
        return $this->trick;
    }

    /**
     * @param trick|null $trick
     * @return Chat
     */
    public function setTrick(?trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
