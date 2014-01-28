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

    /**
     * @test
     */
    public function testName()
    {
        $this->checkField(__FUNCTION__, 'Nature');
    }

    /**
     * @test
     */
    public function testDescription()
    {
        $this->checkField(__FUNCTION__, 'Some description');
    }

    /**
     * @test
     */
    public function testSection()
    {
        $this->checkField(__FUNCTION__, new Section());
    }

    /**
     * @test
     */
    public function testImage()
    {
        $this->checkField(__FUNCTION__, 'image.png');
    }

    /**
     * @test
     */
    public function testToString()
    {
        $this->assertEquals($this->entity->__toString(), $this->entity->getName());
    }

}
