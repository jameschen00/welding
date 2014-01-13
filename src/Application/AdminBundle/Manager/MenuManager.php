<?php
namespace Application\AdminBundle\Manager;

use Application\CoreBundle\Manager\AbstractManager;

/**
 * Manager for the admin menu
 *
 * Class MenuManager
 */
class MenuManager extends AbstractManager
{
    /**
     * @var string
     */
    protected $repositoryName = 'ApplicationAdminBundle:AdminMenu';

    /**
     * @var array
     */
    protected $where = array('e.isActive = :active' => array('active' => 1));

    /**
     * @var array
     */
    protected $order = array('menu_pid' => 'desc', 'sorting' => 'desc');

}
