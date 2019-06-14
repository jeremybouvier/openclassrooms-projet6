<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max = 20, maxMessage = "Le nom ne doit pas excéder 20 charatères")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Group", inversedBy="trick")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chat", mappedBy="trick")
     */
    private $chats;

    /**
<<<<<<< HEAD
     * @ORM\OneToMany(targetEntity="App\Entity\Media", mappedBy="trick",cascade="persist")
=======
     * @ORM\OneToMany(targetEntity="App\Entity\Media", mappedBy="trick")
>>>>>>> a8eda677f29c4ea275ca8c28a4711d6ba96277a8
     */
    private $medias;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_date;

    /**
     * @Assert\File(maxSize="5000000",mimeTypes = {"image/jpeg", "image/png"})
     */
    private $file;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
        $this->medias = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

<<<<<<< HEAD
    public function getGroups(): ?group
=======
    public function getGroup(): ?group
>>>>>>> a8eda677f29c4ea275ca8c28a4711d6ba96277a8
    {
        return $this->groups;
    }

<<<<<<< HEAD
    public function setGroups(?group $groups): self
    {
        $this->groups = $groups;
=======
    public function setGroup(?group $group): self
    {
        $this->groups = $group;
>>>>>>> a8eda677f29c4ea275ca8c28a4711d6ba96277a8

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile|null $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChats(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats[] = $chat;
            $chat->setTrick($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chats->contains($chat)) {
            $this->chats->removeElement($chat);
            // set the owning side to null (unless already changed)
            if ($chat->getTrick() === $this) {
                $chat->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

<<<<<<< HEAD
    public function addMedia(Media $media): self
=======
    public function addMedias(Media $media): self
>>>>>>> a8eda677f29c4ea275ca8c28a4711d6ba96277a8
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setTrick($this);
        }

        return $this;
    }

<<<<<<< HEAD
    public function removeMedia(Media $media): self
=======
    public function removeMedias(Media $media): self
>>>>>>> a8eda677f29c4ea275ca8c28a4711d6ba96277a8
    {
        if ($this->medias->contains($media)) {
            $this->medias->removeElement($media);
            // set the owning side to null (unless already changed)
            if ($media->getTrick() === $this) {
                $media->setTrick(null);
            }
        }

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->update_date;
    }

    public function setUpdateDate(\DateTimeInterface $update_date): self
    {
        $this->update_date = $update_date;

        return $this;
    }

}
