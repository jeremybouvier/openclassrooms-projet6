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
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Chat", mappedBy="trick",cascade={"persist"}, orphanRemoval=true)
     */
    private $chats;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Media", mappedBy="trick",cascade={"persist"}, orphanRemoval=true)
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
     * @var File
     *
     * @ORM\OneToMany(targetEntity="File", mappedBy="trick", cascade={"persist"})
     *
     */
    private $files;

    /**
     * @var ArrayCollection
     */
    private $uploadedFiles;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->uploadedFiles = new ArrayCollection();
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

    public function getGroups(): ?group
    {
        return $this->groups;
    }

    public function setGroups(?group $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    public function setUploadedFiles($uploadedFiles)
    {
        $this->uploadedFiles = $uploadedFiles;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setTrick($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getTrick() === $this) {
                $file->setTrick(null);
            }
        }

        return $this;
    }

    public function upload()
    {
        if (null === $this->getFiles()) {
            return;
        }

        foreach($this->uploadedFiles as $uploadedFile)
        {
            $file = new File();
            $path = 'assets/image/' . md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $file->setPath($path);
            $file->setSize($uploadedFile->getClientSize());
            $file->setName($uploadedFile->getClientOriginalName());
            $uploadedFile->move('assets/image/', $path);

            $this->addFile($file);
            $file->setTrick($this);

            unset($uploadedFile);
        }
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
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

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
            $media->setTrick($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
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
