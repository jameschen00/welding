<?php
namespace Unit\Application\BannerBundle\Entity;

use Application\BannerBundle\Entity\Place;
use Application\CoreBundle\Tests\AbstractEntityTest;
use Application\CoreBundle\Tests\ModifyEntityTraitTest;

/**
 * Class PlaceTest
 */
class PlaceTest extends AbstractEntityTest
{
    use ModifyEntityTraitTest;

    /**
     * @return Place
     */
    protected function createEntity()
    {
        return new Place();
    }

    public function testName()
    {
        $this->checkField(__FUNCTION__, 'Nature');
    }

    public function testWidth()
    {
        $this->checkField(__FUNCTION__, 100);
    }

    public function testHeight()
    {
        $this->checkField(__FUNCTION__, 100);
    }

    public function testCount()
    {
        $this->checkField(__FUNCTION__, 100);
    }

    public function testBseparator()
    {
        $this->checkField(__FUNCTION__, '</li><li>');
    }

    public function testScontainer()
    {
        $this->checkField(__FUNCTION__, '<ul><li>');
    }

    public function testEcontainer()
    {
        $this->checkField(__FUNCTION__, '</li></ul>');
    }

    public function testToString()
    {
        $this->assertEquals($this->entity->__toString(), $this->entity->getName());
    }
}
