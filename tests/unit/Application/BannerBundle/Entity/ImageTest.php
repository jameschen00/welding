<?php
namespace Unit\Application\BannerBundle\Entity;

use Application\BannerBundle\Entity\Banner;
use Application\BannerBundle\Entity\Place;
use Application\CoreBundle\Tests\AbstractEntityTest;

/**
 * Class ImageTest
 */
class ImageTest extends AbstractEntityTest
{
    /**
     * @return Banner
     */
    protected function createEntity()
    {
        return new Banner();
    }

    public function testName()
    {
        $this->checkField(__FUNCTION__, 'Nature');
    }

    public function testPlace()
    {
        $this->checkField(__FUNCTION__, new Place());
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
