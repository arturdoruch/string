<?php

namespace ArturDoruch\String;

/**
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class StringUtils
{
    /**
     * Checks case-sensitively if the string contains a value.
     *
     * @param string $search
     * @param string $string
     *
     * @return bool
     */
    public static function contains(string $search, string $string): bool
    {
        return strpos($string, $search) !== false;
    }

    /**
     * Checks if within given string, exist phrase matches by regexp.
     *
     * @param string $regexp Regular expression pattern.
     * @param string $string
     *
     * @return bool
     */
    public static function containsPattern(string $regexp, string $string): bool
    {
        return preg_match($regexp, $string);
    }


    public static function startsWith(string $search, string $string): bool
    {
        return strpos($string, $search) === 0;
    }


    public static function endsWith(string $search, string $string): bool
    {
        return substr($string, strrpos($string, $search)) === $search;
    }

    /**
     * Finds a value that matches the regexp.
     *
     * @param string $regexp Regular expression with at least one capturing group.
     * @param string $string The string to search within.
     *
     * @return string|null Value matched by the regexp first capturing group.
     */
    public static function find(string $regexp, string $string): ?string
    {
        return preg_match($regexp, $string, $matches) && isset($matches[1]) ? $matches[1] : null;
    }

    /**
     * Finds multiple values that matches the regexp.
     *
     * @param string $regexp Regular expression with at least one capturing group.
     * @param string $string The string to search within.
     *
     * @return array The values matched by the regexp first capturing group.
     */
    public static function findAll(string $regexp, string $string): array
    {
        return preg_match_all($regexp, $string, $matches) && isset($matches[1]) ? $matches[1] : [];
    }

    /*public static function countUppercaseLetters(string $string): int
    {
        return strlen(preg_replace('/[^\p{Lu}]/u', '', $string));
    }*/

    /**
     * Removes empty lines from the formatted text.
     *
     * @param string $text
     *
     * @return string
     */
    public static function removeEmptyLines(string $text): string
    {
        return trim(preg_replace("/([\t ]*(\r?\n|\r))+/", "\n", $text));
    }
}
