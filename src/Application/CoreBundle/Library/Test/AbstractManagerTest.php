<?php
namespace Application\CoreBundle\Library\Test;

/**
 * Abstract Manager test
 */
abstract class AbstractManagerTest extends AbstractApplicationTest
{
    /**
     * @return \Application\CoreBundle\Library\Manager\ManagerAbstract
     */
    abstract protected function manager();

    /**
     * @return object
     */
    abstract public function entityDataProvider();

    /**
     * @return object
     */
    abstract public function findDataProvider();

    /**
     * Create new entity
     *
     * @param object $entity
     *
     * @dataProvider entityDataProvider
     *
     * @return null
     */
    public function testCreate($entity)
    {
        $validator = $this->container->get('validator');
        $errors = $validator->validate($entity);
        if ($errors->count() > 0) {
            $this->assertTrue(false);

            return false;
        }

        $id = $this->manager()->save($entity);
        $this->assertTrue($id > 0);

        return true;
    }


    /**
     * @param array    $find
     * @param callback $callback
     *
     * @dataProvider findDataProvider
     */
    public function testFind($find, $callback)
    {
        $manager = $this->manager();
        isset($find['criteria']) &&  $manager->where($find['criteria']);
        isset($find['order']) &&  $manager->order($find['order']);
        isset($find['limit']) &&  $manager->limit($find['limit']);

        $entities = $manager->findAll();
        $this->assertTrue(call_user_func($callback, $entities));
    }
}
