<?php
namespace Application\ShopBundle\Grid\Type;

use Application\CoreBundle\Manager\AbstractManager;
use Widget\Bundle\Grid\Type\AbstractSymfonyType;
use Widget\Grid\GridBuilder;

/**
 * Class BrandType
 */
class BrandType extends AbstractSymfonyType
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

        //brand_id
        $column = $builder->addColumn('brand_id', 'text', array(
            'title' => $this->translator->trans('brand.id'),
            'width' => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //name
        $column = $builder->addColumn('name', 'text', array(
            'title'    => $this->translator->trans('brand.name'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //active
        $column = $builder->addColumn('active', 'boolean', array(
            'title'    => $this->translator->trans('brand.active'),
            'sortable' => true,
            'width'    => 50
        ));
        $column->setFilter($builder->createFilter('boolean'));

        //created_at
        $column = $builder->addColumn('created_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('brand.created_at'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //updated_at
        $column = $builder->addColumn('updated_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('brand.updated_at'),
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