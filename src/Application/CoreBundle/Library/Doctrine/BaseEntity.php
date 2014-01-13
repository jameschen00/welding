<?php
namespace Application\CoreBundle\Library\Doctrine;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abstract entity, describes main entity function and properties
 *
 * @ORM\MappedSuperclass
 */
abstract class BaseEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
