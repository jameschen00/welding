<?php
namespace Application\GalleryBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;
use Application\CoreBundle\Manager\StandardManager;
use Application\GalleryBundle\Entity\Section;

/**
 * Class ImageManager
 */
class ImageManager extends StandardManager
{
    /**
     * @param Section $section
     *
     * @return $this
     */
    public function setSection(Section $section)
    {
        $this->where(array('e.section IN (:section)' => array('section' => $section)));

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function selectRandom($limit)
    {
        $rows = $this->count();
        $offset = max(0, rand(0, $rows - $limit - 1));

        $this->limit($limit, $offset);

        return $this;
    }

}
