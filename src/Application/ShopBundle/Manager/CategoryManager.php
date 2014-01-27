<?php
namespace Application\ShopBundle\Manager;

use Application\CoreBundle\Helper\TreeHelper;
use Application\CoreBundle\Manager\AbstractManager;

/**
 * Class CategoryManager
 */
class CategoryManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationShopBundle:Category';

    /**
     * @var string
     */
    protected $class = '\Application\ShopBundle\Entity\Category';

    /**
     * @var array
     */
    protected $where = array('e.active = :active' => array('active' => 1));
}
