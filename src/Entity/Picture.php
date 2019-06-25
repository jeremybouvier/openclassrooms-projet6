<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @Assert\File(
     *      maxSize="6000000",
     *      mimeTypes="image/*",
     *      mimeTypesMessage ="Merci de selectionner un fichier image valide")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Tricks;

    public function __construct()
    {
       $this->upload();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getTricks(): ?Trick
    {
        return $this->Tricks;
    }

    public function setTricks(?Trick $Tricks): self
    {
        $this->Tricks = $Tricks;

        return $this;
    }

    /**
     * Gestion du fichier Telechargé
     */
    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }


    public function upload()
    {
        if (null == $this->getFile()){
            return;
        }

        $fileName = $this->generateUniqueFileName().'.'.$this->file->getClientOriginalExtension();

        if ($this->file->move($this->picturesDirectory(), $fileName)){
            $this->path = '/' . $this->picturesDirectory() . $fileName;
        }
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    private function picturesDirectory(){
        return 'assets/image/';
    }
}
