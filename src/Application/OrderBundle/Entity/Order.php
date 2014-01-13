<?php
namespace Application\OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Application\CoreBundle\Library\Doctrine\SlugEntityTrait;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Application\CoreBundle\Library\Doctrine\MetaTagsEntityTrait;

/**
 * order
 *
 * @ORM\Table(name="order")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Order extends BaseEntity
{
    use ModifyEntityTrait;

    /**
     * @var string
     */
    protected $repository = 'ApplicationOrderBundle:Order';

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getOrderId();
    }
}
