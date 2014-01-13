<?php
namespace Application\BannerBundle\Tests\Manager;

use Application\BannerBundle\Entity\Place;
use Application\CoreBundle\Library\Test\AbstractManagerTest;
use Application\BannerBundle\Entity\Banner;

/**
 * Banner manager test
 */
class BannerManagerTest extends AbstractManagerTest
{
    /**
     * {@inheritdoc}
     */
    protected function manager()
    {
        return $this->container->get('manager.banner.banner');
    }

    /**
     * {@inheritdoc}
     */
    public function entityDataProvider()
    {
        $place = new Place();
        $place -> setName('Test place');

        $startDate = new \DateTime();

        $banner = new Banner();
        $banner->setName('Lenovo banner');
        $banner->setPlace($place);
        $banner->setPriority(500);
        $banner->setStartDate($startDate);
        $banner->setIsActive(true);

        return array(
            array($banner)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findDataProvider()
    {
        //test 1
        $find1 = array(
            'criteria' => array('e.isActive = :active' => array('active' => true)),
            'order' => array('priority' => 'desc')
        );
        $checker1 = function($entities) {
            return count($entities) > 0;
        };

        return array(
            array($find1, $checker1),
        );
    }
}
