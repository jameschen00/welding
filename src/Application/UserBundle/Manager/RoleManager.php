<?php
namespace Application\UserBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;

/**
 * Class RoleManager
 */
class RoleManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationUserBundle:Role';

    /**
     * @var string
     */
    protected $class = '\Application\UserBundle\Entity\Role';
}
