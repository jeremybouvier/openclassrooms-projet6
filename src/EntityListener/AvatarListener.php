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
    public function preRemove( $avatar)
    {
        if (!$avatar instanceof Avatar){
            return;
        }

        if ($avatar->getPath() !== '/'){
            unlink(substr($avatar->getPath(),1));
        }
    }

    /**
     * Enregistrement de l'image d'un utilisateur
     * @param $avatar
     */
    public function prePersist( $avatar)
    {
        if (!$avatar instanceof Avatar){
            return;
        }

        if (null == $avatar->getFile()){
            $avatar->setPath('/assets/image/avatar/base.jpg' );
            return;
        }

        $fileName = $this->generateUniqueFileName().'.'.$avatar->getFile()->getClientOriginalExtension();

        if ($avatar->getFile()->move($this->AvatarsDirectory(), $fileName)){
            $avatar->setPath('/' . $this->AvatarsDirectory() . $fileName) ;
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
    private function AvatarsDirectory(){
        return 'assets/image/avatar/';
    }
}