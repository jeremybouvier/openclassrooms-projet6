<?php
/**
 * Created by PhpStorm.
 * Avatar: jeremy
 * Date: 15/07/19
 * Time: 14:37
 */

namespace App\EntityListener;


use App\Entity\Avatar;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class AvatarListener
{
    public function preRemove( $avatar)
    {
        if (!$avatar instanceof Avatar){
            return;
        }

        if ($avatar->getPath() !== '/'){
            unlink(substr($avatar->getPath(),1));
        }
    }
    public function prePersist( $avatar)
    {
        if (!$avatar instanceof Avatar){
            return;
        }

        if (null == $avatar->getFile()){
            return;
        }

        $fileName = $this->generateUniqueFileName().'.'.$avatar->getFile()->getClientOriginalExtension();

        if ($avatar->getFile()->move($this->AvatarsDirectory(), $fileName)){
            $avatar->setPath('/' . $this->AvatarsDirectory() . $fileName) ;
        }
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    private function AvatarsDirectory(){
        return 'assets/image/avatar/';
    }
}