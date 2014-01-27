<?php
namespace Application\CoreBundle\Library\Doctrine;

use Doctrine\ORM\Mapping as ORM;

/**
 * Extend entity to use active field
 */
trait ActiveEntityTrait
{
    /**
     * @ORM\Column(type="boolean", nullable=false, name="is_active")
     *
     * @var boolean isActive
     */
    private $active = false;

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function isActive()
    {
        return $this->active;
    }
}
