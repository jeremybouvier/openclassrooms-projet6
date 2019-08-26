<?php

namespace App\EntityListener;

use App\Entity\Avatar;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class AvatarListener
{
    /**
     * Suppression de l'image d'un utilisateur
     * @param $avatar
     */
    public function preRemove($avatar)
    {
        if (!$avatar instanceof Avatar) {
            return;
        }

        if ($avatar->getPath() !== '/') {
            unlink(substr($avatar->getPath(), 1));
        }
    }

    /**
     * Enregistrement de l'image d'un utilisateur
     * @param $avatar
     * @return true
     */
    public function prePersist($avatar)
    {
        if (!$avatar instanceof Avatar) {
            return;
        }

        if (null == $avatar->getFile()) {
            $avatar->setPath('/assets/image/avatar/base.jpg');
            return;
        }

        $fileName = $this->generateUniqueFileName().'.'.$avatar->getFile()->guessExtension();

        if ($avatar->getFile()->move($this->avatarsDirectory(), $fileName)) {
            $avatar->setPath('/' . $this->avatarsDirectory() . $fileName) ;
            return true;
        }
    }

    /**
     * Creation d'un nom de fichier unique
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    /**
     * Repertoire de stockage des images des utilisateurs
     * @return string
     */
    private function avatarsDirectory()
    {
        return 'assets/image/avatar/';
    }
}
