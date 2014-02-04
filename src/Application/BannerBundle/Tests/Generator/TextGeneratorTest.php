<?php
namespace Application\BannerBundle\Tests\Generator;

use Application\BannerBundle\Entity\Banner;
use Application\BannerBundle\Generator\TextGenerator;

/**
 * Class TextGeneratorTest
 */
class TextGeneratorTest extends \PHPUnit_Framework_TestCase
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
        $this->banner = new Banner();
        $this->banner->setName('Google is the best');
        $this->banner->setUrl('http://google.com');
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
        //check
        $generator = new TextGenerator();
        $generator->setBanner($this->banner);

        $code = $generator->generate();

        //asserts
        $this->assertEquals('<a href="' . $this->banner->getUrl() . '">' . $this->banner->getName() . '</a>', $code);
    }
}
