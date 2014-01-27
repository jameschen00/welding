<?php
namespace Unit\Application\BannerBundle\Generator;

use Application\BannerBundle\Entity\Banner;
use Application\BannerBundle\Generator\GeneratorFactory;
use Application\BannerBundle\Generator\HtmlGenerator;

/**
 * Class GeneratorFactoryTest
 */
class GeneratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testCreate()
    {
        $banner = new Banner();
        $banner->setImg('google.png');

        //mock container
        $cotainer = $this->getMockBuilder('\Symfony\Component\DependencyInjection\Container')
            ->disableOriginalConstructor()
            ->getMock();
        $cotainer->expects($this->once())
            ->method('get')
            ->will($this->returnValue(new HtmlGenerator()));

        $factory = new GeneratorFactory();
        $factory->setContainer($cotainer);
        $generator = $factory->create($banner);

        $this->assertInstanceOf('\Application\BannerBundle\Generator\HtmlGenerator', $generator);
    }
}
