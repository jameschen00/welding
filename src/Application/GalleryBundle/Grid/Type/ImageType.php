<?php
namespace Application\GalleryBundle\Grid\Type;

use Application\CoreBundle\Manager\AbstractManager;
use Widget\Bundle\Grid\Type\AbstractSymfonyType;
use Widget\Grid\GridBuilder;

/**
 * Class ImageType
 */
class ImageType extends AbstractSymfonyType
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

        //gallery_id
        $column = $builder->addColumn('id', 'text', array(
            'title'    => $this->translator->trans('gallery.image.id'),
            'sortable' => true,
            'width'    => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //src
        $builder->addColumn('webPath', 'image', array(
            'title'    => $this->translator->trans('gallery.image.src'),
            'width'    => 70,
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

        //created_at
        $column = $builder->addColumn('created_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('gallery.image.created_at'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //updated_at
        $column = $builder->addColumn('updated_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('gallery.image.updated_at'),
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