<?php

namespace App\Listerner;

use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;


class ImageCacheSubscriber implements EventSubscriber
{

    private CacheManager $cacheManager;
    private UploaderHelper $uploaderHelper;
    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }


    public function getSubscribedEvents()
    {

        return ['preRemove', 'preUpdate'];
    }



    public function preRemove(PreRemoveEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Property) {
            return '';
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }



    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Property) {
            return '';
        }
        if ($entity->getImageFile() instanceof UploadedFile) {
            $entity->setFileName(' ');
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }
}
