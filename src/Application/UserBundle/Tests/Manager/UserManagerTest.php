<?php
namespace Application\UserBundle\Tests\Entity;

use Application\UserBundle\Entity\User;
use Application\UserBundle\Manager\UserManager;
use Application\CoreBundle\Library\Test\AbstractManagerTest;

/**
 * Test user model
 */
class UserAbstractManagerTest extends AbstractManagerTest
{
    /**
     * {@inheritdoc}
     */
    protected function manager()
    {
        return new UserManager($this->em);
    }

    /**
     * {@inheritdoc}
     */
    public function entityDataProvider()
    {
        //user 1
        $user = new User();
        $user->setFirstname('Antoniy');
        $user->setLastname('Kasparov');
        $user->setEmail('g.kasp@case.com');
        $user->setUserPassword('123456');

        //user 2
        $user2 = new User();
        $user2->setFirstname('Jone');
        $user2->setLastname('Dou');
        $user2->setEmail('jone.dou@case.com');
        $user2->setUserPassword('123456');
        $user2->setIsActive(true);

        return array(
            array($user),
            array($user2),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findDataProvider()
    {
        //test 1
        $find1 = array(
            'criteria' => array(
                'e.email = :email'     => array('email' => 'jone.dou@case.com'),
                'e.isActive = :active' => array('active' => true)
            ),
        );
        $checker1 = function($entities) {
            if (count($entities) == 0 || $entities[0]->getFirstname() != 'Jone') {
                return false;
            }

            return true;
        };

        //test 2
        $find2 = array(
            'order' => array(
                'firstname' => 'ASC',
                'lastname'  => 'ASC'
            )
        );
        $checker2 = function($entities) {
            if (count($entities) || $entities[0]->getFirstname() != 'Antoniy') {
                return false;
            }

            return true;
        };

        //result
        return array(
            array($find1, $checker1),
            array($find2, $checker2)
        );
    }
}
