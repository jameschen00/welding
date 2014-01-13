<?php
namespace Application\CoreBundle\Library\Doctrine;

use Doctrine\ORM\Mapping as ORM;

/**
 * Extend entity to using ordering field
 */
trait OrderingEntityTrait
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ordering", type="integer", nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    private $ordering = 500;

    /**
     * Set ordering
     *
     * @param integer $ordering
     *
     * @return Category
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * Get ordering
     *
     * @return integer
     */
    public function getOrdering()
    {
        return $this->ordering;
    }
}
