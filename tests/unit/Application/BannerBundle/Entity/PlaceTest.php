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
    public function testWidth()
    {
        $this->checkField(__FUNCTION__, 100);
    }

    /**
     * @test
     */
    public function testHeight()
    {
        $this->checkField(__FUNCTION__, 100);
    }

    /**
     * @test
     */
    public function testCount()
    {
        $this->checkField(__FUNCTION__, 100);
    }

    /**
     * @test
     */
    public function testBseparator()
    {
        $this->checkField(__FUNCTION__, '</li><li>');
    }

    /**
     * @test
     */
    public function testScontainer()
    {
        $this->checkField(__FUNCTION__, '<ul><li>');
    }

    /**
     * @test
     */
    public function testEcontainer()
    {
        $this->checkField(__FUNCTION__, '</li></ul>');
    }

    /**
     * @test
     */
    public function testWidthPercent()
    {
        $this->checkField(__FUNCTION__, true);
    }
    /**
     * @test
     */
    public function testHeightPercent()
    {
        $this->checkField(__FUNCTION__, true);
    }

    /**
     * @test
     */
    public function testToString()
    {
        $this->assertEquals($this->entity->__toString(), $this->entity->getName());
    }
}
