<?php

/***
 * @author Mohammad
 * Class stringTools provides some basic functions
 * the list of functions are:
 *  concat
 *  writeLn
 *  strToUpper
 *  strToLower
 *  hash
 *  md5
 *  sha512
 *  concatenate
 *  replace
 *  trim
 */
class stringTools
{

    /**
     * Make two string concat
     * @param string $a <p>
     * The input string.
     * </p>
     * @param string $b <p>
     * The input string.
     * </p>
     * @return string the concatenate string.
     */
    public static function concat($a, $b)
    {
        return $a . $b;
    }


    /**
     * write a string with a new line
     * @param string $a <p>
     * The input string.
     * </p>
     * @return string of a string.
     */
    public static function writeLn($a)
    {
        echo $a . "\n";
    }

    /**
     * Make a string uppercase
     * @param string $string <p>
     * The input string.
     * </p>
     * @return string the uppercased string.
     */
    public static function strToUpper($string)
    {
        return strtoupper($string);
    }

    /**
     * Make a string lowercase
     * @param string $string <p>
     * The input string.
     * </p>
     * @return string the lowered string.
     */
    public static function strToLower($string)
    {
        return strtolower($string);
    }

    /**
     * @param string $algorithm <p>
     * Name of selected hashing algorithm (i.e. "md5", "sha256", "haval160,4", etc..)
     * </p>
     * @param string $input <p>
     * Message to be hashed.
     * </p>
     * @param bool $raw_output [optional] <p>
     * When set to <b>TRUE</b>, outputs raw binary data.
     * <b>FALSE</b> outputs lowercase hexits.
     * </p>
     * @return string a string containing the calculated message digest as lowercase hexits
     * unless <i>raw_output</i> is set to true in which case the raw
     * binary representation of the message digest is returned.
     */
    public static function hash($algorithm, $input, $raw_output = false)
    {
        return hash($algorithm, $input, $raw_output);
    }


    /**
     * @param string $input <p>
     * The string.
     * </p>
     * @param bool $raw_output [optional] <p>
     * If the optional raw_output is set to true,
     * then the md5 digest is instead returned in raw binary format with a
     * length of 16.
     * </p>
     * @return string the hash as a 32-character hexadecimal number.
     */
    public static function md5($input, $raw_output = false)
    {
        return md5($input, $raw_output);
    }


    /**
     * @param string $input
     * <p>
     * Message to be hashed.
     * </p>
     * @return string a string hashed with sha512 algorithm
     * unless <i>raw_output</i> is set to true in which case the raw
     * binary representation of the message digest is returned.
     */
    public static function sha512($input)
    {
        return self::hash('sha512', $input);
    }


    /**
     * Make three string concat
     * @param string $a <p>
     * The input string.
     * </p>
     * @param string $b <p>
     * The input string.
     * </p>
     * @param string $c <p>
     * The input string.
     * </p>
     * @return string the concatenate string.
     */
    public static function concatenate($a, $b, $c)
    {
        return $a . $b . $c;
    }

    /**
     * @param mixed $a <p>
     * The value being searched for, otherwise known as the needle.
     * An array may be used to designate multiple needles.
     * </p>
     * @param mixed $b <p>
     * The replacement value that replaces found search
     * values. An array may be used to designate multiple replacements.
     * </p>
     * @param mixed $c <p>
     * The string or array being searched and replaced on,
     * otherwise known as the haystack.
     * </p>
     * @return mixed This function returns a string or an array with the replaced values.
     */
    public static function replace($a, $b, $c)
    {
        return str_replace($a, $b, $c);
    }


    /**
     * @param string $input <p>
     * The string that will be trimmed.
     * </p>
     * @return string The trimmed string.
     */
    public static function trim($input)
    {
        return trim($input);
    }
}

