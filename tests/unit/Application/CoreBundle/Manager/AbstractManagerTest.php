<?php
/**
 * Created by PhpStorm.
 * User: igdr
 * Date: 16.01.14
 * Time: 22:34
 */

class AbstractManagerTest extends \PHPUnit_Framework_TestCase
{
    private $manager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $class = '\Application\GalleryBundle\Entity\Section';
        $repositoryName = 'ApplicationGalleryBundle:Section';
        $this->manager = new \Application\CoreBundle\Manager\StandardManager($class, $repositoryName);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        unset($this->manager);
    }

    public function testAction()
    {
        $this->assertTrue(true);
    }

}
