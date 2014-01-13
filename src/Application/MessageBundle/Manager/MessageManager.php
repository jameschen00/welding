<?php
namespace Application\MessageBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;
use Application\MessageBundle\Entity\CartItem;
use Application\MessageBundle\Entity\Order;
use Application\MessageBundle\Service\CartService;

/**
 * Class MessageManager
 */
class MessageManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $idField = 'messageId';

    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationMessageBundle:Message';
}
