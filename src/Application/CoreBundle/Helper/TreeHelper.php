<?php
namespace Application\CoreBundle\Helper;

/**
 * Хелпер для построение деревьев и работы с ними
 */
class TreeHelper
{
    const CHILD_ID = 1;

    const CHILD_ALL = 2;

    const PARENTID_DEFAULT = 0;

    /**
     * Идентификатор данных
     * @var Integer
     */
    protected $idField = 'id';

    /**
     * Идентификатор "ссылка на родилеть"
     * @var Integer
     */
    protected $pidField = 'pid';

    /**
     * @var Array
     */
    protected $data = array();

    /**
     * @var Array
     */
    protected $active = array();

    /**
     * @var String
     */
    protected $counter = null;

    /**
     * @var Array
     */
    protected $tree = array();

    /**
     * @param object $row
     *
     * @return mixed
     */
    protected function getIdValue($row)
    {
        return $this->getValue($row, $this->idField);
    }

    /**
     * @param object $row
     *
     * @return mixed
     */
    protected function getPidValue($row)
    {
        return $this->getValue($row, $this->pidField);
    }

    /**
     * @param object $row
     * @param string $key
     *
     * @return mixed
     */
    public function getValue($row, $key)
    {
        $mehtod = 'get' . preg_replace("#_([\w])#e", "ucfirst('\\1')", ucfirst($key));

        return call_user_func(array($row, $mehtod));
    }

    /**
     * @param Integer $id
     *
     * @return TreeHelper
     */
    public function setIdField($id)
    {
        $this->idField = $id;

        return $this;
    }

    /**
     * @param Integer $pid
     *
     * @return TreeHelper
     */
    public function setPidField($pid)
    {
        $this->pidField = $pid;

        return $this;
    }

    /**
     * @param Array $data
     *
     * @return TreeHelper
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return TreeHelper
     */
    public function setActive(array $data)
    {
        $this->active = (array) $data;

        return $this;
    }

    /**
     * @param string $counter
     *
     * @return TreeHelper
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;

        return $this;
    }

    /**
     * Build tree
     *
     * @param integer $parentId
     * @param boolean $rebuild
     *
     * @return stdClass
     */
    public function tree($parentId = self::PARENTID_DEFAULT, $rebuild = false)
    {
        if ($rebuild || empty($this->tree[$parentId])) {
            $this->tree[$parentId] = new \stdClass();
            $this->tree[$parentId]->count = 0;

            $this->tree[$parentId]->data = array();
            $this->buildTree($this->data, $this->tree[$parentId]->data, $parentId);
            foreach ($this->tree[$parentId]->data as $row) {
                $this->tree[$parentId]->count += $row['count_child'] + 1;
            }
        }

        return $this->tree[$parentId];
    }

    /**
     * @param array   $data
     * @param array   &$tree
     * @param integer $parentId
     *
     * @return integer
     */
    protected function buildTree($data, &$tree, $parentId = 0)
    {
        $total = 0;
        foreach ($data as $k => &$row) {
            if ($this->getPidValue($row) != $parentId) {
                continue;
            }
            unset($data[$k]);
            $rec = & $tree[];
            $rec = array(
                'data' => $row,
                'active' => in_array($this->getIdValue($row), $this->active),
                'count_child' => 0,
                'path' => array($this->getIdValue($row)),
                'child' => array()
            );
            if ($this->counter) {
                $value = $this->getValue($row, $this->counter);
                $rec['counter'] = !empty($value) ? $value : 0;
            }
            $count = $this->buildTree($data, $rec['child'], $this->getIdValue($row));

            foreach ($rec['child'] as $child) {
                if ($child['active']) {
                    $rec['active'] = true;
                    break;
                }
                if ($this->counter) {
                    $rec['counter'] += !empty($child['counter']) ? $child['counter'] : 0;
                }
            }
            array_unshift($rec['path'], $parentId);
            $rec['count_child'] = $count + count($rec['child']);
            $total += $rec['count_child'];
        }

        return $total;
    }

    /**
     * Get childs list of parent node
     *
     * @param integer $parentId
     * @param integer $mode
     *
     * @return array
     */
    public function child($parentId = 0, $mode = self::CHILD_ID)
    {
        $data = array();
        switch ($mode) {
            case self::CHILD_ID:
            default:
                $data = $this->buildChild($this->data, $parentId);
                break;

            case self::CHILD_ALL:
                $child = $this->buildChild($this->data, $parentId);
                foreach ($this->data as $row) {
                    if (in_array($this->getIdValue($row), $child)) {
                        $data[] = $row;
                    }
                }
                break;
        }

        return $data;
    }

    /**
     * @param array   $data
     * @param integer $parentId
     *
     * @return array
     */
    protected function buildChild($data, $parentId = 0)
    {
        $out = array();
        foreach ($data as $k => $row) {
            if ($this->getPidValue($row) != $parentId) {
                continue;
            }
            unset($data[$k]);
            $out[] = $this->getIdValue($row);
            $arr = $this->buildChild($data, $this->getIdValue($row));
            $out = array_merge($out, $arr);
        }

        return $out;
    }

    /**
     * @param integer $parentId
     * @param integer $mode
     *
     * @return array
     */
    public function childData($parentId = 0, $mode = self::CHILD_ID)
    {
        $data = array();
        switch ($mode) {
            case self::CHILD_ID:
            default:
                $data = $this->buildChildData($this->data, $parentId, false);
                break;

            case self::CHILD_ALL:
                $data = $childs = $this->buildChildData($this->data, $parentId, true);
                foreach ($childs as $child) {
                    if (!empty($child[$this->idField][$this->pidField])) {
                        $data = array_merge($data, $this->_childData($this->data, $child[$this->idField][$this->pidField]));
                    }
                }
                break;
        }

        return $data;
    }

    /**
     * @param array   $data
     * @param integer $parentId
     * @param boolean $recurs
     *
     * @return array
     */
    protected function buildChildData($data, $parentId = 0, $recurs = false)
    {
        $out = array();
        foreach ($data as $k => $row) {
            if ($this->getPidValue($row) != $parentId) {
                continue;
            }
            unset($data[$k]);
            $out[] = $row;
            $arr = $recurs ? $this->buildChildData($data, $this->getIdValue($row), $recurs) : array();
            $out = array_merge($out, $arr);
        }

        return $out;
    }

    /**
     * @return array
     */
    public function getData()
    {
       return $this->data;
    }

    /**
     * @param array  $way
     * @param int    $parentId
     * @param string $key
     *
     * @return array|bool
     */
    public function getBranchByWay(Array $way, $parentId = self::PARENTID_DEFAULT, $key = 'code')
    {
        $result = $this->getBranchByWayRecursive($this->tree($parentId)->data, $way, 0, $key);
        if ($result === false) {
            return false;
        } else {
            return $way;
        }
    }

    /**
     * @param int $id
     * @param int $parentId
     *
     * @return array|false
     */
    public function getBranchById($id, $parentId = self::PARENTID_DEFAULT)
    {
        $result = $this->getBranchByIdRecursive(array('way' => array(), 'finished' => false), $id, $this->tree($parentId)->data);
        if ($result['finished'] === false || sizeof($result['way']) === 0) {
            return false;
        } else {
            return $result['way'];
        }
    }

    /**
     * @param array   $result
     * @param integer $id
     * @param array   $tree
     *
     * @return mixed
     */
    protected function getBranchByIdRecursive($result, $id, $tree)
    {
        foreach ($tree as $item) {
            $dataId = $this->getValue($item['data'], $this->idField);

            $localResult = $result;
            $localResult['way'][$dataId] = $item['data'];
            $localResult['last_id'] = $dataId;
            if ($dataId == $id) {
                $localResult['finished'] = true;

                return $localResult;
            }
            if (sizeof($item['child']) > 0) {
                $localResult = $this->getBranchByIdRecursive($localResult, $id, $item['child']);
                if ($localResult['finished'] === true) {
                    return $localResult;
                }
            }
        }

        return $result;
    }
}
