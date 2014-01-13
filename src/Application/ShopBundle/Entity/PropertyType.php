<?php

namespace Application\ShopBundle\Entity;

/**
 * Default property types.
 */
final class PropertyType
{
    /**
     * Text
     */
    const TYPE_TEXT = 'text';

    /**
     * String
     */
    const TYPE_VARCHAR = 'varchar';

    /**
     * Integer
     */
    const TYPE_INT = 'int';

    /**
     * Array
     */
    const TYPE_ARRAY = 'array';

    /**
     * Textarea
     */
    const INPUT_TEXTAREA = 'textarea';

    /**
     * Text
     */
    const INPUT_TEXT = 'text';

    /**
     * Select
     */
    const INPUT_CHOICE = 'choice';

    /**
     * Multi select
     */
    const INPUT_MULTIPLE_CHOICE = 'multi_choice';

    /**
     * @return array
     */
    public static function getChoices()
    {
        return array(
            self::INPUT_TEXTAREA        => 'textarea',
            self::INPUT_TEXT            => 'text',
            self::INPUT_CHOICE          => 'select',
            self::INPUT_MULTIPLE_CHOICE => 'multiselect'
        );
    }

    /**
     * @param string $input
     *
     * @return string|null
     */
    public static function getDataType($input)
    {
        $types = array(
            self::INPUT_TEXTAREA        => self::TYPE_TEXT,
            self::INPUT_TEXT            => self::TYPE_VARCHAR,
            self::INPUT_CHOICE          => self::TYPE_INT,
            self::INPUT_MULTIPLE_CHOICE => self::TYPE_ARRAY
        );

        return isset($types[$input]) ? $types[$input] : null;
    }

}
