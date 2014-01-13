<?php
namespace Application\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Application\CoreBundle\Library\Doctrine\SlugEntityTrait;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Application\CoreBundle\Library\Doctrine\MetaTagsEntityTrait;

/**
 * One item in cart
 */
class CartItem
{
    /**
     * @var int
     */
    private $productId;

    /**
     * @var int
     */
    private $count = 1;

    /**
     * @var array
     */
    private $params = array();

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->productId;
    }
}
