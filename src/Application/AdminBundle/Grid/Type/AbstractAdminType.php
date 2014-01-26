<?php
namespace Application\AdminBundle\Grid\Type;

use Widget\Bundle\Grid\Type\AbstractSymfonyType;
use Application\CoreBundle\Manager\AbstractManager;
use Widget\Grid\GridBuilder;

/**
 * Class AbstractAdminType
 */
abstract class AbstractAdminType extends AbstractSymfonyType
{
    /**
     * @var AbstractManager
     */
    protected $manager;

    /**
     * @param AbstractManager $manager
     */
    public function __construct(AbstractManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildGrid(GridBuilder $builder, $options = array())
    {
        $this->buildStorage($builder);
        $this->buildColumns($builder);
        $this->buildDateColumns($builder);
        $this->buildToolbar($builder);
        $this->buildExtensions($builder);
        $this->buildActionsGrid($builder);
    }

    /**
     * @param GridBuilder $builder
     */
    protected function buildStorage(GridBuilder $builder)
    {
        //storage
        $builder->setStorage('doctrine', array(
            'repository' => $this->manager->getRepository(),
            'idField'    => $this->manager->getIdField()
        ));
    }

    /**
     * @param GridBuilder $builder
     */
    protected function buildDateColumns(GridBuilder $builder)
    {
        //created_at
        $column = $builder->addColumn('created_at', 'date', array(
            'format'   => 'd.m.Y H:i:s',
            'width'    => 110,
            'sortable' => true,
            'title'    => $this->translator->trans('grid.created_at'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //updated_at
        $column = $builder->addColumn('updated_at', 'date', array(
            'format'   => 'd.m.Y H:i:s',
            'width'    => 110,
            'sortable' => true,
            'title'    => $this->translator->trans('grid.updated_at'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));
    }

    /**
     * @param GridBuilder $builder
     */
    protected function buildExtensions(GridBuilder $builder)
    {
        $builder->addExtension('pagination');
    }

    /**
     * @param GridBuilder $builder
     */
    protected function buildToolbar(GridBuilder $builder)
    {
        $builder->setTopToolbar();
    }

    /**
     * @param GridBuilder $builder
     */
    protected function buildActionsGrid(GridBuilder $builder)
    {
        //add grid actions
        $builder->addAction('update', array('icon' => 'glyphicon glyphicon-pencil'));
        $builder->addAction('delete', array('icon' => 'glyphicon glyphicon-trash'));
    }

    /**
     * @param GridBuilder $builder
     */
    abstract protected function buildColumns(GridBuilder $builder);

}