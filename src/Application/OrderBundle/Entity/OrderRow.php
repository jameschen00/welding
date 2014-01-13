<?php

namespace Application\OrderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Application\CoreBundle\Library\Doctrine\OrderingEntityTrait;
use Application\CoreBundle\Library\Doctrine\SlugEntityTrait;
use Application\CoreBundle\Library\Doctrine\ModifyEntityTrait;
use Application\CoreBundle\Library\Doctrine\MetaTagsEntityTrait;

/**
 * Category
 *
 * @ORM\Table(name="order_row")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class OrderRow extends BaseEntity
{
    use ModifyEntityTrait;

    /**
     * @var string
     */
    protected $repository = 'ApplicationOrderBundle:OrderRow';
}
