<?php
namespace Application\UserBundle\DataFixtures\ORM;

use Application\UserBundle\Entity\Role;
use Application\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class FixtureLoader
 */
class FixtureLoader implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //create role ROLE_ADMIN
        $roleAdmin = new Role();
        $roleAdmin->setName('ROLE_ADMIN');
        $manager->persist($roleAdmin);

        //create role ROLE_SHOP_MANAGER
        $role = new Role();
        $role->setName('ROLE_SHOP_MANAGER');
        $manager->persist($role);

        //create role ROLE_OUTEDITOR
        $role = new Role();
        $role->setName('ROLE_OUTEDITOR');
        $manager->persist($role);

        //create user
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('john@example.com');
        $user->setSalt(md5(time()));

        //set yser password
        $user->setUserPassword('admin');

        $user->getUserRoles()->add($roleAdmin);

        $manager->persist($user);

        $manager->flush();
    }
}
