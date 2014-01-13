<?php
namespace Application\CoreBundle\Library\Pagination\Adapter;

/**
 * Interface for pagination adapters.
 */
interface AdapterInterface extends \Countable
{
    /**
     * Returns an collection of items for a page.
     *
     * @param integer $offset           Page offset
     * @param integer $itemCountPerPage Number of items per page
     *
     * @return array
     */
    public function getItems($offset, $itemCountPerPage);
}
