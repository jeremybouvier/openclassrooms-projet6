<?php

namespace App\EntityListener;

use App\Entity\Picture;

class PictureListener
{
    /**
     * Suppression d'une image d'une figure
     * @param $picture
     * @return bool
     */
    public function preRemove($picture)
    {
        if (!$picture instanceof Picture) {
            return true;
        }

        if ($picture->getPath() !== '/') {
            unlink(substr($picture->getPath(), 1));
            return true;
        }
    }

    /**
     * Enregistrement d'une image d'une figure
     * @param $picture
     * @return bool
     */
    public function prePersist($picture)
    {
        if (!$picture instanceof Picture) {
            return;
        }

        if (null == $picture->getFile()) {
            return;
        }

        $fileName = $this->generateUniqueFileName().'.'.$picture->getFile()->guessExtension();

        return $this->uploadFile($picture, $fileName);
    }

    /**
     * Permet le téléchargement du fichier ainsi que l'actualisation du path dans Picture
     * @param $picture
     * @param $fileName
     * @return bool
     */
    private function uploadFile($picture, $fileName)
    {
        if ($picture->getFile()->move($this->picturesDirectory(), $fileName)) {
            $picture->setPath('/' . $this->picturesDirectory() . $fileName) ;
            return true;
        }
    }

    /**
     * Création d'un nom de fichier unique
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    /**
     * Repertoire de stockage des images des figures
     * @return string
     */
    private function picturesDirectory()
    {
        return 'assets/image/trick/';
    }
}
