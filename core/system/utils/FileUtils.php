<?php

declare(strict_types=1);

namespace Spreng\system\utils;

class FileUtils
{
    public static function fileName($fullFilePath)
    {
        return pathinfo($fullFilePath)['filename'];
    }

    public static function fileExtension($fullFilePath)
    {
        return pathinfo($fullFilePath)['extension'];
    }

    public static function fileBaseName($fullFilePath)
    {
        return pathinfo($fullFilePath)['dirname'];
    }

    public static function get_parent_script()
    {
        $backtrace = debug_backtrace(
            defined("DEBUG_BACKTRACE_IGNORE_ARGS")
                ? DEBUG_BACKTRACE_IGNORE_ARGS
                : FALSE
        );
        $top_frame = array_pop($backtrace);
        return self::fileName($top_frame['file']);
    }

    public static function isPhpFile(string $phpFileName)
    {
        $split = explode('.', $phpFileName);
        return ($split[count($split) - 1] == 'php');
    }

    public static function dirToArray(array $args, string $dir, callable $filter = null): array
    {
        $result = [];
        self::dirToArrayRecursive($args, $dir, $result, $filter);
        return $result;
    }

    private static function dirToArrayRecursive(array $args, string $dir, array &$result, callable $filter = null)
    {

        if ($filter == null) {
            $filter = function ($args, $path) {
                return [null, $path];
            };
        }

        $files = scandir($dir);
        foreach ($files as $key => $value) {
            if (!in_array($value, [".", ".."])) {
                $path = $dir . DIRECTORY_SEPARATOR . $value;
                if (is_dir($path)) {
                    self::dirToArrayRecursive($args, $path, $result, $filter);
                } else {
                    $f = $filter($args, $path);
                    if ($f[1] !== null) {
                        $fvalue = $f[1];
                        if ($f[0] !== null) {
                            $result[$f[0]] = $fvalue;
                        } else {
                            $result[] = $fvalue;
                        }
                    }
                }
            }
        }
    }
}
