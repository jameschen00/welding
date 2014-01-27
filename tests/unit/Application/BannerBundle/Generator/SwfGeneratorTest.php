<?php
namespace Unit\Application\BannerBundle\Generator;

use Application\BannerBundle\Entity\Banner;
use Application\BannerBundle\Entity\Place;
use Application\BannerBundle\Generator\SwfGenerator;

/**
 * Class SwfGeneratorTest
 *
 * @package Unit\Application\BannerBundle\Generator
 */
class SwfGeneratorTest extends \PHPUnit_Framework_TestCase
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
        $this->banner->setImg('google.swf');
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
        $image = 'img/google.swf';

        //mock
        $uploadedHelper = $this->getMockBuilder('\Vich\UploaderBundle\Templating\Helper\UploaderHelper')
            ->disableOriginalConstructor()
            ->getMock();
        $uploadedHelper->expects($this->once())
            ->method('asset')
            ->will($this->returnValue($image));

        //check
        $generator = new SwfGenerator();
        $generator->setBanner($this->banner);
        $generator->setUploaderHelper($uploadedHelper);

        $code = $generator->generate();

        //asserts
        $this->assertTrue(strpos($code, '<embed src="' . $image . '?url=' . $this->banner->getUrl() . '"') !== false);
        $this->assertTrue(strpos($code, 'height="' . $this->banner->getPlace()->getHeight() . '"') !== false);
        $this->assertTrue(strpos($code, 'width="' . $this->banner->getPlace()->getWidth() . '"') !== false);
    }
}
