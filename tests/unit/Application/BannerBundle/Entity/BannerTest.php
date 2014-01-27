<?php
namespace Unit\Application\BannerBundle\Entity;

use Application\BannerBundle\Entity\Banner;
use Application\BannerBundle\Entity\Place;
use Application\CoreBundle\Tests\AbstractEntityTest;
use Application\CoreBundle\Tests\ModifyEntityTraitTest;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class BannerTest
 */
class BannerTest extends AbstractEntityTest
{
    use ModifyEntityTraitTest;

    /**
     * @return Banner
     */
    protected function createEntity()
    {
        return new Banner();
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
    public function testPlace()
    {
        $this->checkField(__FUNCTION__, new Place());
    }

    /**
     * @test
     */
    public function testUrl()
    {
        $this->checkField(__FUNCTION__, 'http://google.com');
    }

    /**
     * @test
     */
    public function testImg()
    {
        $this->checkField(__FUNCTION__, 'google.png');
    }

    /**
     * @test
     */
    public function testCode()
    {
        $this->checkField(__FUNCTION__, '<a href="http://google.com">google.com</a>');
    }

    /**
     * @test
     */
    public function testFile()
    {
        $path = tempnam(sys_get_temp_dir(), 'upl'); // create file
        imagepng(imagecreatetruecolor(10, 10), $path); // create and write image/png to it

        $this->checkField(__FUNCTION__, new UploadedFile($path, 'new_image.png'));
    }

    /**
     * @test
     */
    public function testPriority()
    {
        $this->checkField(__FUNCTION__, 500);
    }

    /**
     * @test
     */
    public function testToString()
    {
        $this->assertEquals($this->entity->__toString(), $this->entity->getName());
    }

}
