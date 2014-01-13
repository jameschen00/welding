<?php
namespace Application\ShopBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;

/**
 * Class PropertyManager
 */
class PropertyManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationShopBundle:Property';

    /**
     * @var string
     */
    protected $class = '\Application\ShopBundle\Entity\Property';

    /**
     * @var array
     */
    protected $where = array('e.isActive = :active' => array('active' => 1));

    /**
     * @param int|array $prototype
     *
     * @return $this
     */
    public function setPrototype($prototype)
    {
        $this->where(array('e.prototype IN (:prototype)' => array('prototype' => $prototype)));

        return $this;
    }
}
