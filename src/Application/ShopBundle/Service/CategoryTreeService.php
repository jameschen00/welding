<?php
namespace Application\ShopBundle\Service;

use Application\CoreBundle\Helper\TreeHelper;
use Application\CoreBundle\Manager\ManagerFactory;

/**
 * Class CategoryTree
 */
class CategoryTreeService
{
    /**
     * @var TreeHelper
     */
    private $tree;

    /**
     * @var ManagerFactory
     */
    private $managerFactory;

    /**
     * @return TreeHelper
     */
    public function getTree()
    {
        if ($this->tree === null) {
            $categories = $this->managerFactory->get('shop_category')->order()->where()->findAll();

            //build tree
            $this->tree = new TreeHelper();
            $this->tree->setIdField('id');
            $this->tree->setPidField('pid');
            $this->tree->setData((array) $categories);
            $this->tree->tree(null);
        }

        return $this->tree;
    }

    /**
     * @param ManagerFactory $factory
     */
    public function setManagerFactory(ManagerFactory $factory)
    {
        $this->managerFactory = $factory;
    }
}