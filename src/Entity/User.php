<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 */
class User implements UserInterface,\Serializable
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
    private $loginName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chat", mappedBy="user")
     */
    private $chats;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Avatar", mappedBy="user", cascade={"persist", "remove"})
     */
    private $avatar;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoginName(): ?string
    {
        return $this->loginName;
    }

    public function setLoginName(string $loginName): self
    {
        $this->loginName = $loginName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chats): self
    {
        if (!$this->chats->contains($chats)) {
            $this->chats[] = $chats;
            $chats->setUser($this);
        }

        return $this;
    }

    public function removeChat(Chat $chats): self
    {
        if ($this->chats->contains($chats)) {
            $this->chats->removeElement($chats);
            // set the owning side to null (unless already changed)
            if ($chats->getUser() === $this) {
                $chats->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     *
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return mixed|string
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
       list(
           $this->id,
           $this->email,
           $this->password
           ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(Avatar $avatar): self
    {
        $this->avatar = $avatar;

        // set the owning side of the relation if necessary
        if ($this !== $avatar->getUser()) {
            $avatar->setUser($this);
        }

        return $this;
    }
}
