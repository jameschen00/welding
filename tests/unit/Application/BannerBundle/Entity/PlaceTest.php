<?php
namespace Unit\Application\BannerBundle\Entity;

use Application\BannerBundle\Entity\Place;
use Application\CoreBundle\Tests\AbstractEntityTest;

/**
 * Class PlaceTest
 */
class PlaceTest extends AbstractEntityTest
{
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

    public function testCreatedAt()
    {
        $this->checkField(__FUNCTION__, new \DateTime());
    }

    public function testUpdatedAt()
    {
        $this->checkField(__FUNCTION__, new \DateTime());
    }

    public function testUpdatedAtValue()
    {
        $this->entity->setUpdatedAtValue();
        $this->assertInstanceOf('\DateTime', $this->entity->getUpdatedAt());
    }

    public function testCreatedAtValue()
    {
        $this->entity->setCreatedAtValue();
        $this->assertInstanceOf('\DateTime', $this->entity->getCreatedAt());
    }

    public function testToString()
    {
        $this->assertEquals($this->entity->__toString(), $this->entity->getName());
    }

}
