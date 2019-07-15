<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 01/07/19
 * Time: 13:50
 */

namespace App\EntityListener;

use App\Entity\Picture;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;



class PictureListener
{
    public function preRemove( $picture)
    {
        if (!$picture instanceof Picture){
            return;
        }

        if ($picture->getPath() !== '/'){
            unlink(substr($picture->getPath(),1));
        }
    }
    public function prePersist( $picture)
    {
        if (!$picture instanceof Picture){
           return;
        }

        if (null == $picture->getFile()){
            return;
        }

        $fileName = $this->generateUniqueFileName().'.'.$picture->getFile()->getClientOriginalExtension();

        if ($picture->getFile()->move($this->picturesDirectory(), $fileName)){
        $picture->setPath('/' . $this->picturesDirectory() . $fileName) ;
        }
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    private function picturesDirectory(){
        return 'assets/image/trick/';
    }
}