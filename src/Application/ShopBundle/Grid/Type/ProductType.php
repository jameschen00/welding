<?php
namespace Application\ShopBundle\Grid\Type;

use Application\CoreBundle\Manager\AbstractManager;
use Widget\Bundle\Grid\Type\AbstractSymfonyType;
use Widget\Grid\GridBuilder;

/**
 * Class ProductType
 */
class ProductType extends AbstractSymfonyType
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

        //product_id
        $column = $builder->addColumn('product_id', 'text', array(
            'title' => $this->translator->trans('product.id'),
            'width' => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //category
        $column = $builder->addColumn('category', 'text', array(
            'title'    => $this->translator->trans('product.category'),
            'sortable' => true,
        ));

        //name
        $column = $builder->addColumn('name', 'text', array(
            'title'    => $this->translator->trans('product.name'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //is_active
        $column = $builder->addColumn('is_active', 'boolean', array(
            'title'    => $this->translator->trans('product.is_active'),
            'sortable' => true,
            'width'    => 50
        ));
        $column->setFilter($builder->createFilter('boolean'));

        //created_at
        $column = $builder->addColumn('created_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('product.created_at'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //updated_at
        $column = $builder->addColumn('updated_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('product.updated_at'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //add grid actions
        $builder->addAction('update', array('icon' => 'glyphicon glyphicon-pencil'));
        $builder->addAction('delete', array('icon' => 'glyphicon glyphicon-trash'));

        //toolbar
        $builder->setTopToolbar('standard');
        $builder->addExtension('pagination');
        //$builder->addExtension('state');
        //$builder->addExtension('columns');
    }
}