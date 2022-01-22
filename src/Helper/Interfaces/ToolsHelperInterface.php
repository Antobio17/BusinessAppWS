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
}