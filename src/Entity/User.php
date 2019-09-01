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
class User implements UserInterface, \Serializable
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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->chats = new ArrayCollection();
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
    public function getLoginName(): ?string
    {
        return $this->loginName;
    }

    /**
     * @param string $loginName
     * @return User
     */
    public function setLoginName(string $loginName): self
    {
        $this->loginName = $loginName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param $plainPassword
     */
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

    /**
     * @param Chat $chats
     * @return User
     */
    public function addChat(Chat $chats): self
    {
        if (!$this->chats->contains($chats)) {
            $this->chats[] = $chats;
            $chats->setUser($this);
        }

        return $this;
    }

    /**
     * @param Chat $chats
     * @return User
     */
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

    /**
     * @return string|null
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * @return Avatar|null
     */
    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    /**
     * @param Avatar $avatar
     * @return User
     */
    public function setAvatar(Avatar $avatar): self
    {
        $this->avatar = $avatar;

        if ($this !== $avatar->getUser()) {
            $avatar->setUser($this);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     * @return User
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
