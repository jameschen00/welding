<?php
namespace Unit\Application\NewsBundle\Entity;

use Application\CoreBundle\Tests\AbstractEntityTest;
use Application\NewsBundle\Entity\Section;

/**
 * Class SectionTest
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

    /**
     * @test
     */
    public function testActive()
    {
        $this->checkField(__FUNCTION__, 1);
    }

    /**
     * @test
     */
    public function testName()
    {
        $this->checkField(__FUNCTION__, 'News');
    }

    /**
     * @test
     */
    public function testSlug()
    {
        $this->checkField(__FUNCTION__, 'news');
    }

    /**
     * @test
     */
    public function testToString()
    {
        $entity = $this->createEntity();
        $entity->setName('News');

        $this->assertEquals($entity->getName(), $entity . '');
    }
}
