<?php
namespace Application\ShopBundle\Grid\Type;

use Application\CoreBundle\Manager\AbstractManager;
use Widget\Bundle\Grid\Type\AbstractSymfonyType;
use Widget\Grid\GridBuilder;

/**
 * Class BrandType
 */
class CategoryType extends AbstractSymfonyType
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
    public function getDefaultsOptions()
    {
        return array(
            'id_field' => 'id',
            'parent_field' => 'pid',
        );
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

        //menu_id
        $builder->addColumn('id', 'text', array(
            'title' => $this->translator->trans('category.id'),
            'width' => 50
        ));

        //name
        $builder->addColumn('name', 'tree', array(
            'title' => $this->translator->trans('category.name'),
        ));

        //name
        $builder->addColumn('prototype', 'text', array(
            'title' => $this->translator->trans('category.prototype'),
        ));

        //active
        $builder->addColumn('active', 'boolean', array(
            'title' => $this->translator->trans('category.active'),
            'width' => 50,
        ));

        //created_at
        $column = $builder->addColumn('created_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('category.created_at'),
        ));

        //updated_at
        $column = $builder->addColumn('updated_at', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('category.updated_at'),
        ));

        //add grid actions
        $builder->addAction('update', array('icon' => 'glyphicon glyphicon-pencil'));
        $builder->addAction('delete', array('icon' => 'glyphicon glyphicon-trash'));

        //toolbar
        $builder->setTopToolbar();
    }
}