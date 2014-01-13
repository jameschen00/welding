<?php
namespace Application\CoreBundle\Library\Pagination\Adapter;

use Application\CoreBundle\Manager\AbstractManager;

/**
 * Adapter for managers
 */
class ManagerAdapter implements AdapterInterface
{
    /**
     * @var ManagerInterface
     */
    protected $manager = null;

    /**
     * Constructor
     *
     * @param AbstractManager $manager
     */
    public function __construct(AbstractManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $this->manager->limit($itemCountPerPage, $offset);

        return $this->manager->findAll();
    }

    /**
     * Returns the total number of rows in the result set.
     *
     * @return integer
     */
    public function count()
    {
        return $this->manager->count();
    }
}
