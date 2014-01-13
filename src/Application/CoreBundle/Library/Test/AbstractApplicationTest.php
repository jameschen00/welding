<?php
namespace Application\CoreBundle\Library\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test case class helpful with Entity tests requiring the database interaction.
 * For regular entity tests it's better to extend standard \PHPUnit_Framework_TestCase instead.
 */
abstract class AbstractApplicationTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $client = $this->createClient();
        $this->container = $client->getContainer();
        $this->em = $this->container->get('doctrine')->getManager();
    }

    /**
     * @return null
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}