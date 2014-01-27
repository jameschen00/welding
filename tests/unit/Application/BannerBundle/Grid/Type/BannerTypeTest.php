<?php
namespace Unit\Application\BannerBundle\Grid\Type;

use Application\BannerBundle\Grid\Type\BannerType;
use Application\CoreBundle\Tests\AbstractGridTest;

/**
 * Class BannerTypeTest
 */
class BannerTypeTest extends AbstractGridTest
{
    /**
     * {@inheritdoc}
     */
    protected function createGrid($manager)
    {
        return new BannerType($manager);
    }
}