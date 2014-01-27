<?php
namespace Application\NewsBundle\Grid\Type;

use Application\AdminBundle\Grid\Type\AbstractAdminType;
use Widget\Grid\GridBuilder;

/**
 * Class SectionType
 */
class SectionType extends AbstractAdminType
{
    /**
     * {@inheritdoc}
     */
    protected function buildColumns(GridBuilder $builder)
    {
        //id
        $column = $builder->addColumn('id', 'text', array(
            'title'    => $this->translator->trans('news.section.id'),
            'sortable' => true,
            'width'    => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //name
        $column = $builder->addColumn('name', 'text', array(
            'title'    => $this->translator->trans('news.section.name'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //slug
        $column = $builder->addColumn('slug', 'text', array(
            'title'    => $this->translator->trans('news.section.slug'),
            'width'    => 100,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //active
        $column = $builder->addColumn('active', 'boolean', array(
            'title'    => $this->translator->trans('news.section.active'),
            'width'    => 50,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('boolean'));
    }
}