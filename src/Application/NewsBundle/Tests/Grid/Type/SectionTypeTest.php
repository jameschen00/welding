<?php
namespace Application\NewsBundle\Tests\Grid\Type;

use Application\CoreBundle\Tests\AbstractGridTest;
use Application\NewsBundle\Grid\Type\SectionType;

/**
 * Class SectionTypeTest
 */
class SectionTypeTest extends AbstractGridTest
{
    /**
     * {@inheritdoc}
     */
    protected function createGrid($manager)
    {
        return new SectionType($manager);
    }
}
