<?php
namespace Application\NewsBundle\Tests\Grid\Type;

use Application\CoreBundle\Tests\AbstractGridTest;
use Application\NewsBundle\Grid\Type\NewsType;

/**
 * Class BannerTypeTest
 */
class NewsTypeTest extends AbstractGridTest
{
    /**
     * {@inheritdoc}
     */
    protected function createGrid($manager)
    {
        return new NewsType($manager);
    }
}