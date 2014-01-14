<?php
namespace Application\NewsBundle\Grid\Type;

use Application\CoreBundle\Manager\AbstractManager;
use Widget\Bundle\Grid\Type\AbstractSymfonyType;
use Widget\Grid\GridBuilder;

/**
 * Class PlaceType
 */
class PlaceType extends AbstractSymfonyType
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
        ///storage
        $builder->setStorage('doctrine', array(
            'repository' => $this->manager->getRepository(),
            'idField'    => $this->manager->getIdField()
        ));

        //id
        $column = $builder->addColumn('place_id', 'text', array(
            'title' => $this->translator->trans('place.id'),
            'sortable' => true,
            'width' => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //name
        $column = $builder->addColumn('name', 'text', array(
            'title' => $this->translator->trans('place.name'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //is_active
        $column = $builder->addColumn('is_active', 'boolean', array(
            'title' => $this->translator->trans('place.active'),
            'width' => 50,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('boolean'));

        //width
        $column = $builder->addColumn('width', 'text', array(
            'title' => $this->translator->trans('place.width'),
            'width' => 100,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //height
        $column = $builder->addColumn('height', 'text', array(
            'title' => $this->translator->trans('place.height'),
            'width' => 100,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //created_at
        $column = $builder->addColumn('created_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('News.created_at'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //updated_at
        $column = $builder->addColumn('updated_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('News.updated_at'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //add grid actions
        $builder->addAction('update', array('icon' => 'glyphicon glyphicon-pencil'));
        $builder->addAction('delete', array('icon' => 'glyphicon glyphicon-trash'));

        //toolbar
        $builder->setTopToolbar();
        $builder->addExtension('pagination');
    }
}