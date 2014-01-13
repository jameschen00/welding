<?php
namespace Application\ShopBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;

/**
 * Class ProductManager
 */
class ProductManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationShopBundle:Product';

    /**
     * @var string
     */
    protected $class = '\Application\ShopBundle\Entity\Product';

    /**
     * @var array
     */
    protected $where = array('e.isActive = :active' => array('active' => 1));

    /**
     * @param int|array $category
     *
     * @return $this
     */
    public function setCategory($category)
    {
        $this->where(array('e.category IN (:category)' => array('category' => $category)));

        return $this;
    }

    /**
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->where(array('e.slug IN (:slug)' => array('slug' => $slug)));

        return $this;
    }

    /**
     * @param array $filters
     *
     * @return $this
     */
    public function setPropertyValue($filters)
    {
        $products = [];
        foreach ($filters as $propertyId => $choices) {
            $property = $this->getEm()->getRepository('ApplicationShopBundle:Property')->find($propertyId);

            $filtered = array();
            foreach ($choices as $val) {
                $records = $this->getEm()->getRepository('ApplicationShopBundle:ProductProperty' . ucfirst($property->getDataType()))->findBy(array('value' => $val));

                foreach ($records as $record) {
                    $filtered[] = $record->getProduct()->getId();
                }
            }

            if (!empty($products)) {
                $products = array_intersect($products, $filtered);
            } else {
                $products = $filtered;
            }
        }
        $this->setId($products);

        return $this;
    }
}
