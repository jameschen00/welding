<?php
namespace Application\CoreBundle\Manager;

/**
 * Class StandardManager
 */
class StandardManager extends AbstractManager
{
    /**
     * @param string $class
     * @param string $repository
     * @param array  $where
     * @param array  $order
     */
    public function __construct($class, $repository, $where = array(), $order = array())
    {
        $this->class = $class;
        $this->repositoryName = $repository;
        $this->order = $order;
        $this->where = $where;
    }
}
