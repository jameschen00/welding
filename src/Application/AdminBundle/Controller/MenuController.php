<?php
namespace Application\AdminBundle\Controller;

use Application\AdminBundle\Form\Type\TreeType;
use Application\AdminBundle\Grid\AdminGridBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Application\AdminBundle\Controller\AbstractAdminController;
use Application\AdminBundle\Manager\MenuManager;
use Widget\Grid\Tree;

/**
 * Menu controller
 *
 * @Route("/menu")
 */
class MenuController extends AbstractAdminController
{
    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        $configuration = new Configuration();
        $configuration->setManager($this->get('manager.admin.menu'));
        $configuration->setPageTitle('page.menu');

        return $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function grid($manager)
    {
        $builder = new AdminGridBuilder('tree', array(
            'idField' => 'menu_id',
            'parentField' => 'menu_pid',
            'pagination' => false
        ));

        //storage
        $builder->setStorage('doctrine', array(
            'model' => $manager->getRepository(),
            'idField' => $manager->getIdField()
        ));

        //menu_id
        $builder->addColumn('menu_id', 'text', array(
            'title' => $this->get('translator')->trans('page.menu.id'),
            'width' => 50,
        ));

        //title
        $builder->addColumn('title', 'tree', array(
            'title' => $this->get('translator')->trans('page.menu.title'),
        ));

        return $builder->getGrid();
    }

    /**
     * {@inheritdoc}
     */
    public function form()
    {
        $form = $this->createFormBuilder($entity, $options)
            ->add('is_active', 'checkbox', array(
                'label' => 'page.menu.active',
            ))

            ->add('menu_pid', new TreeType(new MenuManager($this->getDoctrine()->getManager()), 'menu_pid'), array(
                'label' => 'page.menu.parent',
            ))

            ->add('title', 'text', array(
                'label' => 'page.menu.title',
            ))

            ->add('url', 'text', array(
                'label' => 'page.menu.url',
            ))

            ->add('sorting', 'text', array(
                'label' => 'page.menu.sorting',
            ))

            ->add('shortcut_icon', 'text', array(
                'label' => 'page.menu.icon',
            ));

        return $form->getForm();
    }
}
