<?php
namespace Unit\Application\BannerBundle\Generator;

use Application\BannerBundle\Entity\Banner;
use Application\BannerBundle\Entity\Place;
use Application\BannerBundle\Generator\HtmlGenerator;

/**
 * Class HtmlGeneratorTest
 *
 * @package Unit\Application\BannerBundle\Generator
 */
class HtmlGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Banner
     */
    private $banner;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $place = new Place();
        $place->setWidth(500);
        $place->setHeight(300);

        $this->banner = new Banner();
        $this->banner->setImage('google.png');
        $this->banner->setUrl('http://google.com');
        $this->banner->setPlace($place);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->banner);
    }

    /**
     * @test
     */
    public function testGenerate()
    {
        $image = 'img/google.png';

        //mock
        $uploadedHelper = $this->getMockBuilder('\Vich\UploaderBundle\Templating\Helper\UploaderHelper')
            ->disableOriginalConstructor()
            ->getMock();
        $uploadedHelper->expects($this->once())
            ->method('asset')
            ->will($this->returnValue($image));

        //check
        $generator = new HtmlGenerator();
        $generator->setBanner($this->banner);
        $generator->setUploaderHelper($uploadedHelper);

        $code = $generator->generate();

        $place = $this->banner->getPlace();
        $widthDimensions = $place->isWidthPercent() ? '%' : 'px';
        $heightDimensions = $place->isHeightPercent() ? '%' : 'px';

        //asserts
        $this->assertTrue(strpos($code, '<img src="' . $image . '"') !== false);
        $this->assertTrue(strpos($code, 'height="' . $place->getHeight() . $heightDimensions . '"') !== false);
        $this->assertTrue(strpos($code, 'width="' . $place->getWidth() . $widthDimensions . '"') !== false);
    }
}
