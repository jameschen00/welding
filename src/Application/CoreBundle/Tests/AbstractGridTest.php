<?php
namespace Application\CoreBundle\Tests;

use Widget\Bundle\Grid\Factory;
use Widget\Grid\Grid;

/**
 * Class AbstractEntityTest
 */
abstract class AbstractGridTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param \Application\CoreBundle\Manager\AbstractManager $manager
     *
     * @return Grid
     */
    abstract protected function createGrid($manager);

    /**
     * @test
     */
    public function testGrid()
    {
        //mock repository
        $repository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        //mock $manager
        $manager = $this->getMockBuilder('\Application\CoreBundle\Manager\StandardManager')
            ->disableOriginalConstructor()
            ->getMock();
        $manager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($repository));
        $manager->expects($this->once())
            ->method('getIdField')
            ->will($this->returnValue('id'));

        $translator = $this->getMockBuilder('\Symfony\Bundle\FrameworkBundle\Translation\Translator')
            ->disableOriginalConstructor()
            ->getMock();
        $translator->expects($this->any())
            ->method('trans')
            ->will($this->returnValue('translate'));

        //test grid
        $factory = new Factory();
        $factory->setTranslator($translator);

        //assert
        $this->assertTrue(is_string($factory->createGrid($this->createGrid($manager))->render()));
    }
} 