<?php
namespace Unit\Application\GalleryBundle\Entity;

use Application\CoreBundle\Tests\AbstractEntityTest;
use Application\CoreBundle\Tests\ModifyEntityTraitTest;
use Application\GalleryBundle\Entity\Section;
use Application\GalleryBundle\Entity\Image;

/**
 * Entity Section test
 */
class ImageTest extends AbstractEntityTest
{
    use ModifyEntityTraitTest;

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

    public function testToString()
    {
        $this->assertEquals($this->entity->__toString(), $this->entity->getName());
    }

}
