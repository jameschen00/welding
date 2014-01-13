<?php
namespace Application\BannerBundle\Grid\Type;

use Application\CoreBundle\Manager\AbstractManager;
use Widget\Bundle\Grid\Type\AbstractSymfonyType;
use Widget\Grid\GridBuilder;

/**
 * Class BannerType
 */
class BannerType extends AbstractSymfonyType
{
    /**
     * @var AbstractManager
     */
    private $manager;

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
        //storage
        $builder->setStorage('doctrine', array(
            'repository' => $this->manager->getRepository(),
            'idField'    => $this->manager->getIdField()
        ));

        //banner_id
        $column = $builder->addColumn('banner_id', 'text', array(
            'title'    => $this->translator->trans('banner.id'),
            'sortable' => true,
            'width'    => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //name
        $column = $builder->addColumn('name', 'text', array(
            'title'    => $this->translator->trans('banner.name'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //is_active
        $column = $builder->addColumn('is_active', 'boolean', array(
            'title'    => $this->translator->trans('banner.active'),
            'width'    => 50,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('boolean', array('type' => 'integer')));

        //start_date
        $column = $builder->addColumn('start_date', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('banner.start_date'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //stop_date
        $column = $builder->addColumn('stop_date', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('banner.stop_date'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //created_at
        $column = $builder->addColumn('created_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('banner.created_at'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //updated_at
        $column = $builder->addColumn('updated_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('banner.updated_at'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //add grid actions
        $builder->addAction('update', array('icon' => 'glyphicon glyphicon-pencil'));
        $builder->addAction('delete', array('icon' => 'glyphicon glyphicon-trash'));

        //toolbar
        $builder->setTopToolbar('');
        $builder->addExtension('pagination');
    }
}