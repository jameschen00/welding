<?php
namespace Unit\Application\BannerBundle\Grid\Type;

use Application\BannerBundle\Grid\Type\BannerType;
use Application\BannerBundle\Grid\Type\PlaceType;
use Widget\Bundle\Grid\Factory;

/**
 * Class BannerTypeTest
 */
class BannerTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test create and render
     */
    public function testRender()
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
        $grid = $factory->createGrid(new BannerType($manager));
        $html = $grid->render();

        $this->assertTrue(is_string($html));
    }
}
