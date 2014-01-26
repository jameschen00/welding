<?php
namespace Application\GalleryBundle\Grid\Type;

use Application\AdminBundle\Grid\Type\AbstractAdminType;
use Widget\Grid\GridBuilder;

/**
 * Class ImageType
 */
class ImageType extends AbstractAdminType
{
    /**
     * {@inheritdoc}
     */
    protected function buildColumns(GridBuilder $builder)
    {
        //gallery_id
        $column = $builder->addColumn('id', 'text', array(
            'title'    => $this->translator->trans('gallery.image.id'),
            'sortable' => true,
            'width'    => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //src
        $builder->addColumn('webPath', 'image', array(
            'title' => $this->translator->trans('gallery.image.src'),
            'width' => 70,
        ));

        //name
        $column = $builder->addColumn('name', 'text', array(
            'title'    => $this->translator->trans('gallery.image.name'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //is_active
        $column = $builder->addColumn('is_active', 'boolean', array(
            'title'    => $this->translator->trans('gallery.image.active'),
            'width'    => 50,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('boolean', array('type' => 'integer')));
    }
}