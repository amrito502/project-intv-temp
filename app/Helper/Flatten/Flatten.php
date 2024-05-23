<?php

namespace App\Helper\Flatten;

use RecursiveIteratorIterator;

class Flatten
{

    public static function ArrayFlatten($array)
    {

        if (!is_array($array)) {
            // nothing to do if it's not an array
            return array($array);
        }

        $result = array();
        foreach ($array as $value) {
            // explode the sub-array, and add the parts
            $result = array_merge($result, self::ArrayFlatten($value));
        }

        return $result;

    }
}
