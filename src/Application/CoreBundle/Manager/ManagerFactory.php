<?php
namespace Application\CoreBundle\Manager;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ManagerFactory
 */
class ManagerFactory
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Service prefix
     */
    const PREFIX = 'manager';

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     *
     * @return AbstractManager
     * @throws \Exception
     */
    public function get($name)
    {
        $id = $this->getServiceName($name);;
        if ($this->container->has($id)) {
            return $this->container->get($id);
        } else {
            throw new \Exception(sprintf('Manager with name "%s" not found', $name));
        }
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function getServiceName($name)
    {
        $arr = explode('_', $name);
        array_splice($arr, 1, 0, array(self::PREFIX));

        return join('_', $arr);
    }

}