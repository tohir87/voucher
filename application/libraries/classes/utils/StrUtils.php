<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace utils;

/**
 * Description of StrUtils
 *
 * @author JosephT
 */
class StrUtils {

//put your code here


    const CASE_LOWER = -1;
    const CASE_NORMAL = 0;
    const CASE_UPPER = 1;
    const CAMEL_CASE_STYLE_UCFIRST = 1;
    const CAMEL_CASE_STYLE_LCFIRST = 2;

    protected static $allowedTags = "<a><b><blockquote><code><del><dd><dl><dt><em><h1><h2><h3><i><img><kbd><li><ol><p><u><pre><s><sup><sub><strike><span><font><strong><ul><br/><hr/>";

    /**
     *
     * @param string $str
     * @param string $with
     * @return string the new string 
     */
    public static function replaceNonAlphaNumeric($str, $with = '_') {
        return preg_replace('/[^A-Za-z0-9_]/', $with, $str);
    }

    /**
     * convert camelCasedString to delimeted_string
     * @param string $str camel cased string
     * @param type $delimeter
     * @param int $case to use for pieces (class::CASE_LOWER, class::CASE_UPPER, class::CASE_NORMAL), 
     * defaults to class::CASE_LOWER
     * @return string delimeted_string
     * 
     */
    public static function camelCaseToDelimited($str, $delimeter = '_', $case = self::CASE_LOWER) {
        $pieces = preg_split('/([[:upper:]][[:lower:]]+)/', $str, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        foreach ($pieces as $i => $piece) {
            if ($case == self::CASE_LOWER) {
                $pieces[$i] = strtolower($piece);
            } elseif ($case == self::CASE_UPPER) {
                $pieces[$i] = strtoupper($piece);
            }
        }
        return join($delimeter, $pieces);
    }

    /**
     * convert delimeted_string to camelCasedString
     * @param string $string the delimeted string to convert
     * @param string $delimeterPattern delimeter pattter to use to split string, must be compatible with preg_spit
     * defaults to _
     * @param string $style Style to use class::CAMEL_CASE_STYLE_LCFIRST (e.g. functionName, varName) or 
     * class::CAMEL_CASE_STYLE_UCFIRST (e.g. ClassName)
     * defaults to class::CAMEL_CASE_STYLE_LCFIRST
     * @return string camelCasedString
     */
    public static function delimetedToCamelCased($string, $delimeterPattern = '/_/', $style = self::CAMEL_CASE_STYLE_LCFIRST) {
        $parts = preg_split($delimeterPattern, $string);

        foreach ($parts as $i => $part) {
            if ($i == 0 && $style == self::CAMEL_CASE_STYLE_LCFIRST) {
                $parts[$i] = strtolower($part);
            } else {
                $parts[$i] = ucfirst(strtolower($part));
            }
        }

        return join('', $parts);
    }

    /**
     * remove prefix from string
     * @param str $string
     * @param str $prefix
     * @return string
     */
    public static function removePrefixFromString($string, $prefix) {
        return substr($string, strlen($prefix));
    }

    public static function getAllowedTags() {
        return self::$allowedTags;
    }

    public static function stripTags($str) {
        return strip_tags($str, self::$allowedTags);
    }

    public static function sanitize($str, $separator = '-', $style = self::CASE_LOWER) {
        $sanitised = preg_replace('/[^a-zA-Z0-9-_]+/', $separator, $str);
        if ($style == self::CASE_UPPER) {
            return strtoupper($sanitised);
        } else if ($style == self::CASE_LOWER) {
            return strtolower($sanitised);
        } else {
            return $sanitised;
        }
    }

    static public function startsWith($haystack, $needle) {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    static public function endsWith($haystack, $needle) {
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }

    public static function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),
                // 16 bits for "time_hi_and_version",
// four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,
                // 16 bits, 8 bits for "clk_seq_hi_res",
// 8 bits for "clk_seq_low",
// two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,
                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public static function depluralize($word) {
        // Here is the list of rules. To add a scenario,
        // Add the plural ending as the key and the singular
        // ending as the value for that key. This could be
        // turned into a preg_replace and probably will be
        // eventually, but for now, this is what it is.
        //
    // Note: The first rule has a value of false since
        // we don't want to mess with words that end with
        // double 's'. We normally wouldn't have to create
        // rules for words we don't want to mess with, but
        // the last rule (s) would catch double (ss) words
        // if we didn't stop before it got to that rule. 
        $rules = array(
            'ss' => false,
            'os' => false,
            'is' => false,
            'as' => false,
            'us' => false,
            'ies' => 'y',
            'xes' => 'x',
            'oes' => 'o',
            'ies' => 'y',
            'ves' => 'f',
            'ae' => 'a',
            'ices' => 'ex',
            's' => '',
        );
        // Loop through all the rules and do the replacement. 
        foreach (array_keys($rules) as $key) {
            // If the end of the word doesn't match the key,
            // it's not a candidate for replacement. Move on
            // to the next plural ending. 
            if (substr($word, (strlen($key) * -1)) != $key) {
                continue;
            }
            // If the value of the key is false, stop looping
            // and return the original version of the word. 
            if ($key === false) {
                return $word;
            }
            // We've made it this far, so we can do the
            // replacement. 
            return substr($word, 0, strlen($word) - strlen($key)) . $rules[$key];
        }
        return $word;
    }

}
