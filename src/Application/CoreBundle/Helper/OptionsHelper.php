<?php
namespace Application\CoreBundle\Helper;

/**
 * Хелпер конструктора клсасов
 */
class OptionsHelper
{
    /**
     * @param string $key name param
     *
     * @return string
     */
    protected static function normalizeKey($key)
    {
        $option = str_replace('_', ' ', strtolower($key));
        $option = str_replace(' ', '', ucwords($option));

        return $option;
    }

    /**
     * Gets a parameter from the $entity.  If the
     * parameter does not exist, NULL will be returned.
     *
     * If the parameter does not exist and $default is set, then
     * $default will be returned instead of NULL.
     *
     * @param object $entity
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function getParam($entity, $key, $default = null)
    {
        $method = 'get' . self::normalizeKey($key);

        $value = $default;
        if (method_exists($entity, $method)) {
            $value = call_user_func(array($entity, $method));
        }

        return $value;
    }
}
