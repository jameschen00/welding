<?php
namespace Application\UserBundle\Grid\Type;

use Application\CoreBundle\Manager\AbstractManager;
use Widget\Bundle\Grid\Type\AbstractSymfonyType;
use Widget\Grid\GridBuilder;

/**
 * Class UserType
 */
class UserType extends AbstractSymfonyType
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

        //user_id
        $column = $builder->addColumn('user_id', 'text', array(
            'title' => $this->translator->trans('user.id'),
            'width' => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //firstname
        $column = $builder->addColumn('firstname', 'text', array(
            'title' => $this->translator->trans('user.firstname'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //lastname
        $column = $builder->addColumn('lastname', 'text', array(
            'title' => $this->translator->trans('user.lastname'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //email
        $column = $builder->addColumn('email', 'text', array(
            'title' => $this->translator->trans('user.email'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //active
        $column = $builder->addColumn('is_active', 'boolean', array(
            'title' => $this->translator->trans('user.active'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('boolean'));

        //add grid actions
        $builder->addAction('update', array('icon' => 'glyphicon glyphicon-pencil'));
        $builder->addAction('delete', array('icon' => 'glyphicon glyphicon-trash'));

        //toolbar
        $builder->setTopToolbar();
        $builder->addExtension('pagination');
    }
}