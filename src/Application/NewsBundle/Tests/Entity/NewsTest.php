<?php
namespace Application\NewsBundle\Tests\Entity;

use Application\CoreBundle\Tests\AbstractEntityTest;
use Application\NewsBundle\Entity\News;
use Application\NewsBundle\Entity\Section;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class News
 */
class NewsTest extends AbstractEntityTest
{
    /**
     * @return News
     */
    protected function createEntity()
    {
        return new News();
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
    public function testTitle()
    {
        $this->checkField(__FUNCTION__, 'Title');
    }

    /**
     * @test
     */
    public function testImage()
    {
        $this->checkField(__FUNCTION__, 'sample.png');
    }

    /**
     * @test
     */
    public function testSection()
    {
        $this->checkField(__FUNCTION__, new Section());
    }

    /**
     * @test
     */
    public function testShortText()
    {
        $this->checkField(__FUNCTION__, 'text text text text');
    }

    /**
     * @test
     */
    public function testFullText()
    {
        $this->checkField(__FUNCTION__, '<b>text</b> text <p>text text</p>');
    }

    /**
     * @test
     */
    public function testFile()
    {
        $file = tempnam(sys_get_temp_dir(), 'upl'); // create file
        imagepng(imagecreatetruecolor(10, 10), $file); // create and write image/png to it
        $uploadedFile = new UploadedFile($file, 'new_image.png');

        $this->checkField(__FUNCTION__, $uploadedFile);
    }

    /**
     * @test
     */
    public function testStartDate()
    {
        $this->checkField(__FUNCTION__, new \DateTime());
    }

    /**
     * @test
     */
    public function testStopDate()
    {
        $this->checkField(__FUNCTION__, new \DateTime());
    }

    /**
     * @test
     */
    public function testToString()
    {
        $entity = $this->createEntity();
        $entity->setTitle('title');

        $this->assertEquals($entity->getTitle(), $entity . '');
    }
}
