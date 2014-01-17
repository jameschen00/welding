<?php
namespace Application\CoreBundle\Tests;

use Doctrine\ORM\Mapping as ORM;

trait ModifyEntityTraitTest
{
    public function testCreatedAt()
    {
        $this->checkField(__FUNCTION__, new \DateTime());
    }

    public function testUpdatedAt()
    {
        $this->checkField(__FUNCTION__, new \DateTime());
    }

    public function testUpdatedAtValue()
    {
        $this->entity->setUpdatedAtValue();
        $this->assertInstanceOf('\DateTime', $this->entity->getUpdatedAt());
    }

    public function testCreatedAtValue()
    {
        $this->entity->setCreatedAtValue();
        $this->assertInstanceOf('\DateTime', $this->entity->getCreatedAt());
    }
}
