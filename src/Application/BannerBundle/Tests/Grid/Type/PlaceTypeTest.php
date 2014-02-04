<?php
namespace Application\BannerBundle\Tests\Grid\Type;

use Application\BannerBundle\Grid\Type\PlaceType;
use Application\CoreBundle\Tests\AbstractGridTest;

/**
 * Class PlaceTypeTest
 */
class PlaceTypeTest extends AbstractGridTest
{
    /**
     * {@inheritdoc}
     */
    protected function createGrid($manager)
    {
        return new PlaceType($manager);
    }
}
