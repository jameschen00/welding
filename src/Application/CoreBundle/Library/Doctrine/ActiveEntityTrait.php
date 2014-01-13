<?php
namespace Application\CoreBundle\Library\Doctrine;

use Doctrine\ORM\Mapping as ORM;

/**
 * Extend entity to use is_active field
 */
trait ActiveEntityTrait
{
    /**
     * @ORM\Column(type="boolean", nullable=false, name="is_active")
     *
     * @var string isActive
     */
    private $isActive = false;

    /**
     * @param string $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string
     */
    public function hasIsActive()
    {
        return $this->isActive;
    }
}
