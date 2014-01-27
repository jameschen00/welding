<?php
namespace Application\ShopBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;

/**
 * Class BrandManager
 */
class BrandManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationShopBundle:Brand';

    /**
     * @var string
     */
    protected $class = '\Application\ShopBundle\Entity\Brand';

    /**
     * @var array
     */
    protected $where = array('e.active = :active' => array('active' => 1));
}
