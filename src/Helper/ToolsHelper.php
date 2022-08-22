<?php

namespace App\Helper;

use App\Helper\Interfaces\ToolsHelperInterface;

class ToolsHelper implements ToolsHelperInterface
{

    /************************************************* CONSTANTS **************************************************/

    public const STRING_TYPE_ALPHA = 'alpha';
    public const STRING_TYPE_NUMERIC = 'numeric';
    public const STRING_TYPE_ALPHA_NUMERIC = 'alpha-numeric';

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

    /**
     * @inheritDoc
     * @return string string
     */
    public static function randStr(int $length = 5, ?string $type = NULL, bool $capitalize = FALSE,
                                   bool $withSpecialChars = TRUE, ?string $specialChars = NULL): string
    {
        $specialChars = $specialChars ?? '!|@#~$%&?_-+';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        switch ($type):
            case static::STRING_TYPE_ALPHA:
                $firstIndex = 10;
                $lastIndex = strlen($characters) - $firstIndex - 1;
                break;
            case static::STRING_TYPE_NUMERIC:
                $firstIndex = 0;
                $lastIndex = 9;
                break;
            case static::STRING_TYPE_ALPHA_NUMERIC:
            default:
                $firstIndex = 0;
                $lastIndex = strlen($characters) - $firstIndex - 1;
                break;
        endswitch;

        $choices = substr($characters, $firstIndex, $lastIndex);
        $choices .= $withSpecialChars ? $specialChars : '';
        $randomString = '';
        for ($i = 1; $i <= $length; $i++):
            $randomString .= $choices[rand(0, strlen($choices) - 1)];
        endfor;

        if ($capitalize):
            $randomString = strtoupper($randomString);
        endif;

        return $randomString;
    }
}