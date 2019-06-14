<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 */
class Media
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
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
<<<<<<< HEAD
     * @ORM\ManyToOne(targetEntity="App\Entity\trick", inversedBy="medias",cascade="persist")
=======
     * @ORM\ManyToOne(targetEntity="App\Entity\trick", inversedBy="medias")
>>>>>>> a8eda677f29c4ea275ca8c28a4711d6ba96277a8
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $header;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTrick(): ?trick
    {
        return $this->trick;
    }

    public function setTrick(?trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }

    public function getHeader(): ?bool
    {
        return $this->header;
    }

    public function setHeader(?bool $header): self
    {
        $this->header = $header;

        return $this;
    }
}
