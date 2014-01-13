<?php
namespace Application\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class Builder
 */
class Builder extends ContainerAware
{
    /**
     * @param FactoryInterface $factory
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory)
    {
        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'page-sidebar-menu');

        $menu->addChild('Dashboard', array('route' => 'adminbundle_homepage'))
            ->setAttribute('icon', 'fa fa-briefcase');

        //user
        $menu->addChild('Users')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-user');

        $menu['Users']->addChild('Users', array('route' => 'application_user_admin_user_index'));
        $menu['Users']->addChild('Roles', array('route' => 'application_user_admin_role_index'));

        //shop
        $menu->addChild('Shop')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-shopping-cart');

        $menu['Shop']->addChild('Products', array('route' => 'application_shop_admin_product_index'));
        $menu['Shop']->addChild('Categories', array('route' => 'application_shop_admin_category_index'));
        $menu['Shop']->addChild('Brands', array('route' => 'application_shop_admin_brand_index'));
        $menu['Shop']->addChild('Properties', array('route' => 'application_shop_admin_property_index'));
        $menu['Shop']->addChild('Prototype', array('route' => 'application_shop_admin_prototype_index'));


        //banner
        $menu->addChild('Banner')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa  fa-th-large');

        $menu['Banner']->addChild('Banners', array('route' => 'application_banner_admin_banner_index'));
        $menu['Banner']->addChild('Places', array('route' => 'application_banner_admin_place_index'));

        //Setings
        $menu->addChild('Settings')
            ->setAttribute('dropdown', true)
            ->setAttribute('icon', 'fa fa-gear');

        return $menu;
    }
}