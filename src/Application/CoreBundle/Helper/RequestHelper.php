<?php
namespace Application\CoreBundle\Helper;

/**
 * Формирование и разбор параметров урла вида base64
 * /shop/catalog/product/add/params/eyJjYXRlZ29yeV9pZCI6IjQ0MSJ9 (category_id => 346)
 */
class RequestHelper
{
    /**
     * @var Array
     */
    private $params = array();

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getParam($key)
    {
        return array_key_exists($key, $this->params) ? $this->params[$key] : '';
    }

    /**
     * @return \stdClass
     */
    public function getParams()
    {
        return (object) $this->params;
    }

    /**
     * @return string
     */
    public function encode()
    {
        return base64_encode(json_encode($this->params));
    }

    /**
     * @param string $hash
     *
     * @return $this
     */
    public function decode($hash)
    {
        $this->params = $this->arrayMap('urldecode', (array) json_decode(base64_decode($hash), true));

        return $this;
    }

    /**
     * @param string $func
     * @param array  $arr
     *
     * @return array
     */
    private function arrayMap($func, array $arr)
    {
        foreach ($arr as &$row) {
            if (is_array($row)) {
                $row = $this->arrayMap($func, $row);
            } else {
                $row = call_user_func($func, $row);
            }
        }

        return $arr;
    }
}
