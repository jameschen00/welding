<?php
namespace Application\BannerBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;

/**
 * Class BrandManager
 */
class BannerManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationBannerBundle:Banner';

    /**
     * @var string
     */
    protected $class = '\Application\BannerBundle\Entity\Banner';

    /**
     * @var array
     */
    protected $where = array('e.isActive = :active' => array('active' => 1));

    /**
     * @param int $place
     *
     * @return $this
     */
    public function setPlace($place)
    {
        $this->where(array('e.place IN (:place)' => array('place' => $place)));

        return $this;
    }

}
