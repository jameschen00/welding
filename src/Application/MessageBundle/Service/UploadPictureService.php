<?php
namespace Application\MessageBundle\Service;

use Application\MessageBundle\Entity\Message;
use Doctrine\ORM\EntityManager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;


/**
 * Shopping cart
 */
class UploadPictureService implements ConsumerInterface
{
    /**
     * @var EntityManager
     */
    protected $em = null;

    /**
     * @param AMQPMessage $msg
     */
    public function execute(AMQPMessage $msg)
    {
        $message = new Message();
        $message->setMessage($msg->body);
        $this->em->persist($message);
        $this->em->flush();
    }

    /**
     * @param EntityManager $em
     *
     * @return AbstractManager
     */
    public function setEm(EntityManager $em)
    {
        $this->em = $em;

        return $this;
    }
}
