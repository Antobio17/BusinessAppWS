<?php

namespace App\Helper\Interfaces;


interface ToolsHelperInterface
{

    /*********************************************** STATIC METHODS ***********************************************/

    /**
     * Gets the simplified FQN class name.
     *
     * @param string $FQNClassName The FQN class name to simplify.
     *
     * @return string string
     */
    static function clearFQNClassName(string $FQNClassName): string;

    /**
     * Gets the stringify methods with the class like: class::method.
     *
     * @param string $FQNClassName The FQN class name to stringify.
     * @param string $method The method to stringify.
     *
     * @return string string
     */
    static function getStringifyMethod(string $FQNClassName, string $method): string;

    /**
     * Gets an array from a string passed.
     *
     * @param string|null $string String to convert to an array.
     *
     * @return array
     */
    static function getStringAsArray(?string $string): array;

    /**
     * Encrypts the string passed by parameters.
     *
     * @param string $str String to encrypt.
     * @param string $secretToken Secret token for the encryption.
     *
     * @return string string
     */
    static function encrypt(string $str, string $secretToken): string;

    /**
     * Decrypts the string passed by parameters.
     *
     * @param string $str String to decrypt.
     * @param string $secretToken Secret token for the decryption.
     *
     * @return string string
     */
    static function decrypt(string $str, string $secretToken): string;

    /**
     * Generates a random string of the length and type supplied
     *
     *      return string Random string
     *
     * @param int $length If not supplied defaults to 5 characters
     * @param string|null $type Accepted values are "alpha" | "num" defaults to alphaNumeric
     * @param bool $capitalize To capitalize the random string.
     * @param bool $withSpecialChars To add special charts.
     * @param string|null $specialChars More special charts specified.
     *
     * @return string string
     */
    public static function randStr(int $length = 5, ?string $type = NULL, bool $capitalize = FALSE,
                                   bool $withSpecialChars = TRUE, ?string $specialChars = NULL): string;

}