<?php
namespace Application\ShopBundle\Service;

use Application\ShopBundle\Entity\PropertyChoice;

/**
 * Filter for products in category
 */
class FilterChoice
{
    /**
     * @var PropertyChoice
     */
    private $propertyChoice;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var boolean
     */
    private $selected;

    /**
     * @var int
     */
    private $count;

    /**
     * @param int $count
     *
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param boolean $selected
     *
     * @return $this
     */
    public function setSelected($selected)
    {
        $this->selected = $selected;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSelected()
    {
        return $this->selected;
    }


    /**
     * @param boolean $active
     *
     * @return $this;
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param \Application\ShopBundle\Entity\PropertyChoice $propertyChoice
     *
     * @return $this;
     */
    public function setPropertyChoice($propertyChoice)
    {
        $this->propertyChoice = $propertyChoice;

        return $this;
    }

    /**
     * @return \Application\ShopBundle\Entity\PropertyChoice
     */
    public function getPropertyChoice()
    {
        return $this->propertyChoice;
    }
}