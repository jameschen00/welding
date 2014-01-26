<?php
namespace Application\BannerBundle\Grid\Type;

use Application\AdminBundle\Grid\Type\AbstractAdminType;
use Widget\Grid\GridBuilder;

/**
 * Class BannerType
 */
class BannerType extends AbstractAdminType
{
    /**
     * {@inheritdoc}
     */
    protected function buildColumns(GridBuilder $builder)
    {
        //banner_id
        $column = $builder->addColumn('id', 'text', array(
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
            'sortable' => true,
            'title'  => $this->translator->trans('banner.start_date'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //stop_date
        $column = $builder->addColumn('stop_date', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'sortable' => true,
            'title'  => $this->translator->trans('banner.stop_date'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));
    }
}