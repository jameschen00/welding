<?php
namespace Application\ShopBundle\Service;

use Application\CoreBundle\Manager\AbstractManager;
use Application\CoreBundle\Manager\ManagerFactory;
use Application\ShopBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

/**
 * Filter for products in category
 */
class FilterService
{
    /**
     * @var Category
     */
    private $category;

    /**
     * @var AbstractManager
     */
    private $manager;

    /**
     * @var string
     */
    private $url;

    /**
     * @var \Application\CoreBundle\Manager\ManagerFactory
     */
    private $managerFactory;

    /**
     * @var array
     */
    private $filters;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $properties;

    /**
     * @var int
     */
    private $totalCount;

    /**
     * @var int
     */
    private $selectedCount;

    /**
     * @param ManagerFactory $factory
     */
    public function __construct(ManagerFactory $factory)
    {
        $this->filters = Request::createFromGlobals()->get('f');
        $this->managerFactory = $factory;
        $this->properties = new ArrayCollection();
    }

    /**
     * @param Category $category
     *
     * @return $this
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @param AbstractManager $manager
     *
     * @return $this
     */
    public function setManager(AbstractManager $manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Create url for link in filter template
     *
     * @param FilterProperty $property
     * @param FilterChoice   $choice
     *
     * @return string
     */
    public function createUrl(FilterProperty $property, FilterChoice $choice)
    {
        $key = $property->getProperty()->getId() . '-' . $choice->getPropertyChoice()->getChoiceId();


        $url = array();
        $url[$key] = 'f[' . $property->getProperty()->getId() . '][]=' . $choice->getPropertyChoice()->getChoiceId();

        if (!empty($this->filters)) {
            foreach ($this->filters as $propertyId => $choices) {
                foreach ((array) $choices as $value) {
                    $key2 = $propertyId . '-' . $value;
                    $url[$key2] = 'f[' . $propertyId . '][]=' . $value;
                }
            }
        }

        if ($choice->isSelected()) {
            unset($url[$key]);
        }

        return $this->getUrl() . '?' . join('&', $url);
    }

    function getMicrotime()
    {
        list($msec,$sec) = explode(" ",microtime());
        return floatval($sec) + floatval($msec);
    }

    /**
     * Run filter
     */
    public function filter()
    {
        //calculate properties
        $this->calculateProperties();

        //total count
        $this->totalCount = $this->manager->count();

        //apply filters
        $this->applyFiltersToManager($this->manager, $this->filters);

        //selected count
        $this->selectedCount = $this->manager->count();
    }

    /**
     * Calculate list of properties
     */
    private function calculateProperties()
    {
        $productValues = $this->calculateState();
        $selectedValues = $this->calculateState($this->filters);

        foreach ($this->getCategoryProperties() as $property) {
            if (count($property->getChoices()) > 0) {
                $filterProperty = new FilterProperty();
                $filterProperty->setProperty($property);

                $filterChoices = new ArrayCollection();
                foreach ($property->getChoices() as $choice) {
                    $arr = array_keys($productValues[$property->getId()]);
                    $arrActive = array_keys((array) @$selectedValues[$property->getId()]);

                    if (in_array($choice->getChoiceId(), $arr)) {
                        $active = in_array($choice->getChoiceId(), $arrActive);
                        $selected = @is_array($this->filters[$property->getId()]) && in_array($choice->getChoiceId(), $this->filters[$property->getId()]);

                        $filterChoice = new FilterChoice();
                        $filterChoice->setPropertyChoice($choice);
                        $filterChoice->setCount(@$selectedValues[$property->getId()][$choice->getChoiceId()]);
                        $filterChoice->setActive($active);
                        $filterChoice->setSelected($selected);
                        $filterChoices->add($filterChoice);

                        if ($selected) {
                            $filterProperty->setSelected(true);
                        }
                    }
                }

                $filterProperty->setChoices($filterChoices);

                $this->properties->add($filterProperty);
            }
        }
    }

    /**
     * Calculate filter state
     *
     * @param array $filters
     *
     * @return array
     */
    private function calculateState($filters = array())
    {
        $products = $this->getProducts($filters);
        $properties = $this->getCategoryProperties();

        $productValues = array();
        foreach ($properties as $property) {
            if (count($property->getChoices()) > 0) {
                $valuesManager = $this->managerFactory->get('shop_product_property');
                $valuesManager->setProduct($products)->setProperty($property->getId());
                $values = $valuesManager->findAll();

                foreach ($values as $value) {
                    foreach ((array)$value->getValue() as $v) {
                        if (!isset($productValues[$property->getId()][(int) $v])) {
                            $productValues[$property->getId()][(int) $v] = 1;
                        } else {
                            $productValues[$property->getId()][(int) $v]++;
                        }
                    }
                }
            }
        }

        return $productValues;
    }

    /**
     * Apply filters to product manager
     *
     * @param AbstractManager $manager
     * @param array           $filters
     *
     * @return AbstractManager
     */
    private function applyFiltersToManager(AbstractManager $manager, $filters)
    {
        if (!empty($filters)) {
            $manager->setPropertyValue($filters);
        }

        return $manager;
    }

    /**
     * Get products list by filter
     *
     * @param array $filters
     *
     * @return Array
     */
    private function getProducts($filters)
    {
        $manager = clone $this->manager;
        if (!empty($filters)) {
            $this->applyFiltersToManager($manager, $filters);
        }

        return $manager->getId();
    }

    /**
     * Get calculated properties for filter template
     *
     * @return ArrayCollection
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Get properties list from category
     *
     * @return ArrayCollection
     */
    private function getCategoryProperties()
    {
        return $this->category->getPrototype()->getProperties();
    }

    /**
     * @return int
     */
    public function getSelectedCount()
    {
        return $this->selectedCount;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }
}