<?php
namespace Application\BannerBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;


/**
 * Class BrandManager
 */
class PlaceManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationBannerBundle:Place';

    /**
     * @var string
     */
    protected $class = '\Application\BannerBundle\Entity\Place';
}
