<?php
namespace Application\NewsBundle\Manager;

use Application\CoreBundle\Manager\StandardManager;
use Application\NewsBundle\Entity\Section;

/**
 * Class NewsManager
 */
class NewsManager extends StandardManager
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
}
