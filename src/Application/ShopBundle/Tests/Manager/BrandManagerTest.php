<?php
namespace Application\ShopBundle\Tests\Manager;

use Application\CoreBundle\Library\Test\AbstractManagerTest;
use Application\ShopBundle\Manager\BrandManager;
use Application\ShopBundle\Entity\Brand;

/**
 * Brand model test
 */
class BrandManagerTest extends AbstractManagerTest
{
    /**
     * {@inheritdoc}
     */
    protected function manager()
    {
        return $this->container->get('manager.shop.brand');
    }

    /**
     * {@inheritdoc}
     */
    public function entityDataProvider()
    {
        $brand = new Brand();
        $brand->setName('Lenovo');
        $brand->setSlug('lenovo');

        $brand2 = new Brand();
        $brand2->setName('Acer');
        $brand2->setSlug('acer-brand');

        $brand3 = new Brand();
        $brand3->setName('Sony');
        $brand3->setSlug('very-long-brand-slug-and-and-very-very-long');
        $brand3->setIsActive(true);

        return array(
            array($brand),
            array($brand2),
            array($brand3)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findDataProvider()
    {
        //test 1
        $find1 = array(
            'order' => array('name' => 'asc')
        );
        $checker1 = function($entities) {
            if ($entities[1]->getName() == 'Lenovo') {
                return true;
            }

            return false;
        };

        //test 2
        $find2 = array(
            'criteria' => array('e.isActive = :active' => array('active' => true)),
            'order' => array('name' => 'asc')
        );
        $checker2 = function($entities) {
            return count($entities) > 0;
        };

        return array(
            array($find1, $checker1),
            array($find2, $checker2)
        );
    }
}
