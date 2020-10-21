<?php
namespace App\Listenner\Image;

use App\Entity\Utilisateur;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Class ImageCacheSubscriber
 * @package App\Listenner\Image
 * @author jaures kano <ruddyjaures@mail.com>
 */
class ImageCacheSubscriber implements EventSubscriber
{

    private $cacheManager;

    private $uploaderHelper;

    /**
     * ImageCacheSubscriber constructor.
     * @param CacheManager $cacheManager
     * @param UploaderHelper $uploaderHelper
     */
    public function __construct(CacheManager $cacheManager , UploaderHelper $uploaderHelper )
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove( LifecycleEventArgs $args ){
        $entity = $args->getEntity();
        if( !$entity instanceof Utilisateur ){
            return;
        }

        $this->cacheManager->remove( $this->uploaderHelper->asset($entity , 'imageFile' ));
    }

    public function preUpdate( PreUpdateEventArgs $args ){

        $entity = $args->getEntity();
        if( !$entity instanceof Utilisateur ){
            return;
        }

        if( $entity->getImageFile() instanceof  UploadedFile ){

            $this->cacheManager->remove( $this->uploaderHelper->asset($entity , 'imageFile' ));
        }

    }

}

