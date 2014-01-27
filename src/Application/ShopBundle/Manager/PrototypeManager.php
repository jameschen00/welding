<?php
namespace Application\ShopBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;

/**
 * Product prototype model
 */
class PrototypeManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationShopBundle:Prototype';

    /**
     * @var string
     */
    protected $class = '\Application\ShopBundle\Entity\Prototype';

    /**
     * @var array
     */
    protected $where = array('e.active = :active' => array('active' => 1));

}
