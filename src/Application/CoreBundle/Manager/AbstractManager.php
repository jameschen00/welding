<?php
namespace Application\CoreBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AbstractManager
 */
abstract class AbstractManager
{
    /**
     * @var string
     */
    protected $idField;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var Array
     */
    protected $order = array();

    /**
     * @var Array
     */
    protected $where = array();

    /**
     * @var EntityRepository
     */
    protected $repository = null;

    /**
     * @var string
     */
    protected $repositoryName = null;

    /**
     * @var EntityManager
     */
    protected $em = null;

    /**
     * @var QueryBuilder
     */
    protected $query = null;

    /**
     * @return QueryBuilder
     */
    public function getQuery()
    {
        if ($this->query === null) {
            $this->query = $this->getRepository()->createQueryBuilder('e');
        }

        return $this->query;
    }

    /**
     * @param EntityRepository $repository
     *
     * @return $this
     */
    public function setRepository(EntityRepository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * @return EntityRepository
     */
    public function getRepository()
    {
        if (empty($this->repository)) {
            $this->setRepository($this->em->getRepository($this->repositoryName));
        }

        return $this->repository;
    }

    /**
     * @param EntityManager $em
     *
     * @return $this
     */
    public function setEm($em)
    {
        $this->em = $em;

        return $this;
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param string $repositoryName
     *
     * @return $this
     */
    public function setRepositoryName($repositoryName)
    {
        $this->repositoryName = $repositoryName;

        return $this;
    }

    /**
     * @return string
     */
    public function getRepositoryName()
    {
        return $this->repositoryName;
    }

    /**
     * Get list of all ids
     *
     * @return Array
     */
    public function getId()
    {
        return $this->getValue($this->getIdField());
    }

    /**
     * Get records from database
     *
     * @return array The objects.
     */
    public function findAll()
    {
        $items = $this->find();

        return $items;
    }

    /**
     * Get one record
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function findOne()
    {
        $this->limit(1);
        $items = $this->findAll();

        return !empty($items) ? array_shift($items) : null;
    }

    /**
     * @return String
     */
    public function getIdField()
    {
        if (empty($this->idField)) {
            $this->idField = $this->em->getClassMetadata($this->class)->identifier[0];
        }

        return $this->idField;
    }

    /**
     * @param Array $order
     *
     * @return $this
     */
    public function order($order = array())
    {
        empty($order) && $order = $this->order;
        foreach ((array) $order as $name => $dir) {
            $this->getQuery()->addOrderBy('e.' . $this->normalize($name), $dir);
        }

        return $this;
    }

    /**
     * @param Array $where
     *
     * @return $this
     */
    public function where($where = array())
    {
        empty($where) && $where = $this->where;
        foreach ((array) $where as $name => $value) {
            if (is_numeric($name)) {
                $this->getQuery()->andWhere($value);
            } else {
                $this->getQuery()->andWhere($name);
                $this->getQuery()->setParameter(key($value), current($value));
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    protected function find()
    {
        $result = $this->getQuery()->getQuery()->getResult();

        return $result;
    }

    /**
     * @param String $field
     *
     * @return Integer
     */
    public function count($field = null)
    {
        $query = clone $this->getQuery();
        $query = $query->select($field ? 'count(e.' . $this->normalize($field) . ')' : 'count(e)')->getQuery();
        /* @var $query Query */
        $count = $query->getSingleScalarResult();

        return $count;
    }

    /**
     * Get list of values
     *
     * @param string $field
     * @param bool   $unique
     *
     * @return array
     */
    public function getValue($field, $unique = true)
    {
        $query = clone $this->getQuery();

        /* @var $query Query */
        if (strpos($field, 'e.') === false) {
            $query = $query->select('DISTINCT e.' . $this->normalize($field))->getQuery();
        } else {
            $query = $query->select($this->normalize($field))->getQuery();
        }

        $queryResult = $query->getScalarResult();
        $result = array();
        foreach ($queryResult as $row) {
            $result[] = array_shift($row);
        }

        return $unique ? array_unique($result) : $result;
    }

    /**
     * @param Integer $count
     * @param Integer $offset
     *
     * @return $this
     */
    public function limit($count, $offset = 0)
    {
        $this->getQuery()->setFirstResult($offset);
        $this->getQuery()->setMaxResults($count);

        return $this;
    }

    /**
     * @param Integer|Array|String $id
     *
     * @return $this
     */
    public function setId($id)
    {
        empty($id) && $id = 0;
        $this->where(array('e.' . $this->getIdField() . ' IN (:id)' => array('id' => $id)));

        return $this;
    }

    /**
     * Create new entity
     *
     * @return object
     */
    public function create()
    {
        return new $this->class;
    }

    /**
     * @param object $data
     * @param bool   $andFlush
     *
     * @return $this
     */
    public function save($data, $andFlush = true)
    {
        $this->em->persist($data);

        if ($andFlush) {
            $this->em->flush();
        }

        return $this;
    }

    /**
     * @param integer|object $data
     * @param bool           $andFlush
     *
     * @return $this
     * @throws \Exception
     */
    public function delete($data, $andFlush = true)
    {
        if (is_numeric($data)) {
            $this->setId($data);
            $entity = $this->findOne();
        } elseif (is_object($data)) {
            $entity = $data;
        } else {
            throw new \Exception('Unknown format of input parameter');
        }

        $this->em->remove($entity);

        if ($andFlush) {
            $this->em->flush();
        }

        return $this;
    }

    /**
     * Normalize field name to doctrine name - entity_id => entityId
     *
     * @param String $field
     *
     * @return String
     */
    protected function normalize($field)
    {
        return preg_replace("#_([a-z])#e", "ucfirst('\\1')", $field);
    }

    /**
     * clone
     */
    function __clone()
    {
        $this->query = clone $this->query;
    }


}
