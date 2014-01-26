<?php
namespace Application\GalleryBundle\Grid\Type;

use Application\AdminBundle\Grid\Type\AbstractAdminType;
use Widget\Grid\GridBuilder;

/**
 * Class BannerType
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
            'title'    => $this->translator->trans('gallery.section.id'),
            'sortable' => true,
            'width'    => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //name
        $column = $builder->addColumn('name', 'text', array(
            'title'    => $this->translator->trans('gallery.section.name'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //is_active
        $column = $builder->addColumn('is_active', 'boolean', array(
            'title'    => $this->translator->trans('gallery.section.active'),
            'width'    => 50,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('boolean'));
    }
}