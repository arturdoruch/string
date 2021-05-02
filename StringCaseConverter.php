<?php

namespace ArturDoruch\StringUtil;

/**
 * String case converter.
 *
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class StringCaseConverter
{
    /**
     * Converts a string to pascal case "PascalCase".
     *
     * @param string $string
     *
     * @return string
     */
    public static function toPascal(string $string): string
    {
        return self::camel($string, true);
    }

    /**
     * Converts a string to camel case "camelCase".
     *
     * @param string $string
     *
     * @return string
     */
    public static function toCamel(string $string): string
    {
        return self::camel($string, false);
    }

    private static function camel($string, $ucFirst)
    {
        return preg_replace_callback('/_([\pL\d])|^(\pL)/u', static function($chars) use ($ucFirst) {
            return isset($chars[2]) ? ($ucFirst ? mb_strtoupper($chars[2]) : mb_strtolower($chars[2])) : mb_strtoupper($chars[1]);
        }, preg_replace('/[^\pL\d]+([\pL])/u', '_$1', $string));
    }

    /**
     * Converts a string to snake case "snake_case".
     *
     * @param string $string
     *
     * @return string
     */
    public static function toSnake(string $string): string
    {
        return mb_strtolower(preg_replace_callback('/(?<!_|^)([\p{Lu}])/u', static function($chars) {
            return '_' . $chars[1];
        }, preg_replace('/[^\pL\d]+([\pL])/u', '_$1', $string)));
    }

    /**
     * Converts a string to kebab case "kebab-case".
     *
     * @param string $string
     *
     * @return string
     */
    public static function toKebab(string $string): string
    {
        return str_replace('_', '-', self::toSnake($string));
    }

    /**
     * Converts a string to title format.
     *
     *  - Replaces the _- characters into space.
     *  - Makes uppercase the first letter in the: string, first word after the dot.
     *
     * @param string $string
     * @param bool $uppercaseFirstLetters Whether to uppercase first letter in all words.
     *
     * @return string
     */
    public static function toTitle(string $string, bool $uppercaseFirstLetters = false): string
    {
        return preg_replace_callback('/((^|\.? )[\p{Ll}])/u', static function ($matches) use (&$uppercaseFirstLetters) {
            return $matches[1][0] !== ' ' || $uppercaseFirstLetters ? mb_strtoupper($matches[1]) : $matches[1];
        }, trim(str_replace(['_', '-'], ' ', $string)));
    }

    /**
     * Converts a string to filename.
     *
     *  - Removes the forbidden characters in a file or directory name, in specified operation system.
     *  - Replaces multiple spaces into one.
     *
     * https://stackoverflow.com/a/31976060/4159607
     *
     * @param string $string
     * @param string $os Name of the operation system for which rules with the allowed characters in
     *                   a file or directory name should be applied. One of the values: "windows", "unix", "mac".
     * @param int $length The length to which string should be truncated.
     *
     * @return string
     */
    public static function toFilename(string $string, string $os = 'windows', int $length = null): string
    {
        if ($os === 'windows') {
            $patterns = [
                '/[\/\\\*\:\?"<>\|\x00-\x1F]|\.+$/',
                '/^(AUX|CON|COM[1-9]|LPT[1-9]|NUL|PRN)$/i',
            ];
        } elseif ($os === 'unix') {
            $patterns = ['/\/|\x00/'];
        } elseif ($os === 'mac') {
            $patterns = ['/:/'];
        } else {
            throw new \InvalidArgumentException(sprintf('Invalid operation system name "%s". Permissible values are: "windows", "unix", "mac".'));
        }

        $string = preg_replace($patterns, '', $string);

        return trim(mb_substr(preg_replace('/ {2,}/', ' ', $string), 0, $length));
    }
}
