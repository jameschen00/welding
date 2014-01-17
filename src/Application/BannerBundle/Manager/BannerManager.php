<?php
namespace Application\BannerBundle\Manager;

use Application\CoreBundle\Manager\StandardManager;

/**
 * Class BrandManager
 */
class BannerManager extends StandardManager
{
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
