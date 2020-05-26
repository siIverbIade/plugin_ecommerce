<?php

namespace Spreng\system\utils;

class Debug
{
    static public function print(array $object, bool $print_r = false, bool $htmbr = false)
    {
        if (!$print_r) {
            if ($htmbr) $lb = "</br>";
            else $lb = "\n";
            foreach ($object as $key => $value) {
                if (is_array($value)) {
                    echo "<" . $key . ">" . $lb;
                    self::print($value, $print_r, $htmbr);
                    echo "</" . $key . ">" . $lb;
                } else {
                    echo $key . " = " . $value . $lb;
                }
            }
        } else {
            print_r($object);
        }
    }

    static function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }
}
