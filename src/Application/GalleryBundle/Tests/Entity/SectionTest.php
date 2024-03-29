<?php
namespace Application\GalleryBundle\Tests\Entity;

use Application\CoreBundle\Tests\AbstractEntityTest;
use Application\CoreBundle\Tests\ModifyEntityTraitTest;
use Application\GalleryBundle\Entity\Section;

/**
 * Entity Section test
 */
class SectionTest extends AbstractEntityTest
{
    use ModifyEntityTraitTest;

    /**
     * @return Section
     */
    protected function createEntity()
    {
        return new Section();
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
    public function testToString()
    {
        $this->assertEquals($this->entity->__toString(), $this->entity->getName());
    }

}
