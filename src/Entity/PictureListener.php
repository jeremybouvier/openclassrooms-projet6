<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 01/07/19
 * Time: 13:50
 */

namespace App\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;



class PictureListener
{
    public function preRemove(LifecycleEventArgs $eventArgs)
    {

        if ($eventArgs->getObject()->getPath() !== '/'){
            unlink(substr($eventArgs->getObject()->getPath(),1));
        }
    }
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        if (null == $eventArgs->getObject()->getFile()){
            return;
        }

        $fileName = $this->generateUniqueFileName().'.'.$eventArgs->getObject()->getFile()->getClientOriginalExtension();

        if ($eventArgs->getObject()->getFile()->move($this->picturesDirectory(), $fileName)){
        $eventArgs->getObject()->setPath('/' . $this->picturesDirectory() . $fileName) ;
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