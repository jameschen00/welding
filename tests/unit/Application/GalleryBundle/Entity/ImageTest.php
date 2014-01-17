<?php
namespace Unit\Application\GalleryBundle\Entity;

use Application\CoreBundle\Tests\AbstractEntityTest;
use Application\GalleryBundle\Entity\Section;
use Application\GalleryBundle\Entity\Image;

/**
 * Entity Section test
 */
class ImageTest extends AbstractEntityTest
{
    /**
     * @return Image
     */
    protected function createEntity()
    {
        return new Image();
    }

    public function testName()
    {
        $this->checkField(__FUNCTION__, 'Nature');
    }

    public function testDescription()
    {
        $this->checkField(__FUNCTION__, 'Some description');
    }

    public function testSection()
    {
        $this->checkField(__FUNCTION__, new Section());
    }

    public function testImg()
    {
        $this->checkField(__FUNCTION__, 'image.png');
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
