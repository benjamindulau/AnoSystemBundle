<?php

namespace Ano\Bundle\SystemBundle;

class Inflector
{
    /**
     * Converts input into an URL friendly string
     *
     * @param  string $input  Text to slugify
     * @return string $output Slugified text
     */
    public static function slugify($input)
    {
        // replace non letter or digits by -
        $output = preg_replace('~[^\\pL\d]+~u', '-', $input);

        // trim
        $output = trim($output, '-');

        // transliterate
        if (function_exists('iconv')) {
            $output = iconv('utf-8', 'us-ascii//TRANSLIT', $output);
        }

        // lowercase
        $output = strtolower($output);

        // remove unwanted characters
        $output = preg_replace('~[^-\w]+~', '', $output);

        return $output;
    }
}