<?php
namespace Application\ShopBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Filter for products in category
 */
class FilterProperty
{
    /**
     * @var Property
     */
    private $property;

    /**
     * @var ArrayCollection
     */
    private $choices;

    /**
     * @var boolean
     */
    private $selected;

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
     * @param \Doctrine\Common\Collections\ArrayCollection $choices
     *
     * @return $this
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param \Application\ShopBundle\Service\Property $property
     *
     * @return $this
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return \Application\ShopBundle\Service\Property
     */
    public function getProperty()
    {
        return $this->property;
    }
}