<?php
namespace Application\CoreBundle\Library\Pagination\Adapter;

/**
 * Adapter for arrays
 */
class ArrayAdapter implements AdapterInterface
{
    /**
     * Array
     *
     * @var array
     */
    protected $array = null;

    /**
     * Item count
     *
     * @var integer
     */
    protected $count = null;

    /**
     * Constructor.
     *
     * @param array $array Array to paginate
     */
    public function __construct(array $array)
    {
        $this->_array = $array;
        $this->_count = count($array);
    }

    /**
     * {@inheritdoc}
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return array_slice($this->array, $offset, $itemCountPerPage);
    }

    /**
     * Returns the total number of rows in the array.
     *
     * @return integer
     */
    public function count()
    {
        return $this->count;
    }
}