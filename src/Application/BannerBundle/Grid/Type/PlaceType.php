<?php
namespace Application\BannerBundle\Grid\Type;

use Application\AdminBundle\Grid\Type\AbstractAdminType;
use Widget\Grid\GridBuilder;

/**
 * Class PlaceType
 */
class PlaceType extends AbstractAdminType
{
    /**
     * {@inheritdoc}
     */
    protected function buildColumns(GridBuilder $builder)
    {
        //id
        $column = $builder->addColumn('id', 'text', array(
            'title'    => $this->translator->trans('place.id'),
            'sortable' => true,
            'width'    => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //name
        $column = $builder->addColumn('name', 'text', array(
            'title'    => $this->translator->trans('place.name'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //active
        $column = $builder->addColumn('active', 'boolean', array(
            'title'    => $this->translator->trans('place.active'),
            'width'    => 50,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('boolean'));

        //width
        $column = $builder->addColumn('width', 'text', array(
            'title'    => $this->translator->trans('place.width'),
            'width'    => 100,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //height
        $column = $builder->addColumn('height', 'text', array(
            'title'    => $this->translator->trans('place.height'),
            'width'    => 100,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));
    }
}