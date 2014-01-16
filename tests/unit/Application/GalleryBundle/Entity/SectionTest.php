<?php
namespace Unit\Application\GalleryBundle\Entity;

use Application\CoreBundle\Tests\AbstractEntityTest;
use Application\GalleryBundle\Entity\Section;

/**
 * Entity Section test
 */
class SectionTest extends AbstractEntityTest
{
    /**
     * @return Section
     */
    protected function createEntity()
    {
        return new Section();
    }

    public function testName()
    {
        $this->checkField(__FUNCTION__, 'Nature');
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
