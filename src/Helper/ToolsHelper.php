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

    /**
     * @inheritDoc
     * @return string string
     */
    static function encrypt(string $str, string $secretToken): string
    {
        $data = openssl_encrypt($str, 'AES-128-ECB', $secretToken, OPENSSL_RAW_DATA);

        return base64_encode($data);
    }

    /**
     * @inheritDoc
     * @return string string
     */
    static function decrypt(string $str, string $secretToken): string
    {
        return openssl_decrypt(base64_decode($str), 'AES-128-ECB', $secretToken, OPENSSL_RAW_DATA);
    }
}