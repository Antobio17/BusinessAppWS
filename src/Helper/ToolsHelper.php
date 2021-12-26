<?php

namespace App\Helper;

use App\Helper\Interfaces\ToolsHelperInterface;

class ToolsHelper implements ToolsHelperInterface
{

    /************************************************* CONSTANTS **************************************************/

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return string string
     */
    static function clearFQNClassName(string $FQNClassName): string
    {
        $className = $FQNClassName;
        if (strpos($className, '\\') !== FALSE):
            $className = substr(strrchr($className, '\\'), 1);
        endif;

        return $className;
    }

    /**
     * @inheritDoc
     * @return string string
     */
    static function getStringifyMethod(string $FQNClassName, string $method): string
    {
        $className = static::clearFQNClassName($FQNClassName);
        return $className . '::' . $method;
    }

    /**
     * @inheritDoc
     * @return array
     */
    static function getStringAsArray(?string $string): array
    {
        return $string !== NULL ? unserialize($string, array('allowed_classes' => TRUE)) : array();
    }

}