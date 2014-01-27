<?php
namespace Application\NewsBundle\Grid\Type;

use Application\AdminBundle\Grid\Type\AbstractAdminType;
use Application\CoreBundle\Manager\AbstractManager;
use Widget\Bundle\Grid\Type\AbstractSymfonyType;
use Widget\Grid\GridBuilder;

/**
 * Class NewsType
 */
class NewsType extends AbstractAdminType
{
    /**
     * {@inheritdoc}
     */
    protected function buildColumns(GridBuilder $builder)
    {
        //news_id
        $column = $builder->addColumn('id', 'text', array(
            'title'    => $this->translator->trans('news.item.id'),
            'sortable' => true,
            'width'    => 50,
        ));
        $column->setFilter($builder->createFilter('text', array('type' => 'integer')));

        //name
        $column = $builder->addColumn('title', 'text', array(
            'title'    => $this->translator->trans('news.item.title'),
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('text'));

        //active
        $column = $builder->addColumn('active', 'boolean', array(
            'title'    => $this->translator->trans('news.item.active'),
            'width'    => 50,
            'sortable' => true,
        ));
        $column->setFilter($builder->createFilter('boolean', array('type' => 'integer')));

        //start_date
        $column = $builder->addColumn('start_date', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('news.item.start_date'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));

        //stop_date
        $column = $builder->addColumn('stop_date', 'date', array(
            'format' => 'd.m.Y H:i:s',
            'width'  => 110,
            'title'  => $this->translator->trans('news.item.stop_date'),
        ));
        $column->setFilter($builder->createFilter('DateRange'));
    }
}