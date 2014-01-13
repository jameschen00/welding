<?php
namespace Application\UserBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;

/**
 * Class UserManager
 */
class UserManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationUserBundle:User';

    /**
     * @var string
     */
    protected $class = '\Application\UserBundle\Entity\User';
}
