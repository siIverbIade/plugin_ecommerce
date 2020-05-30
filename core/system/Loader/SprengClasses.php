<?php

namespace Spreng\system\Loader;

use Spreng\config\GlobalConfig;
use Spreng\system\utils\FileUtils;

class SprengClasses
{

    private static function isInstanceOf(string $phpFile, string $sprengClass): bool
    {
        if (FileUtils::isPhpFile($phpFile)) {
            $tokens = token_get_all(file_get_contents($phpFile));
            $extends = 0;
            foreach ($tokens as $i => $v) {
                if ($v[0] !== T_WHITESPACE && $extends !== 0) {
                    $className = $v[1];
                    break;
                }
                if ($v[0] == T_EXTENDS) {
                    $extends = $i;
                }
            }
            if (!isset($className)) return false;
            $uses = '';
            foreach ($tokens as $i => $v) {
                if (isset($v[1])) $uses .= $v[1];
                if ($v[0] == T_CLASS) break;
            }

            if (strpos(trim($uses), "use $sprengClass") !== false && FileUtils::fileName($sprengClass) == $className) return true;
        }
        return false;
    }

    public static function scanFromSource(string $baseFolder, string $sprengClass): array
    {
        $filter = function ($args, $path) {
            if (self::isInstanceOf($path, $args['test_class'])) {
                $class = FileUtils::fileName($path);
                $currDir = FileUtils::fileBaseName($path);
                $full = str_replace($args['initial_dir'], '', $currDir . "\\" . $class);
                $srcClass = GlobalConfig::getSystemConfig()->getSourceClass();
                $full = str_replace('\\\\', '\\', $srcClass . $args['base_folder'] . $full);
                return [$full, $args['test_class']];
            };
            return [null, null];
        };
        $args['initial_dir'] = GlobalConfig::getSystemConfig()->getSourcePath() . "/$baseFolder";
        $args['base_folder'] = $baseFolder;
        $args['test_class'] = $sprengClass;
        return FileUtils::dirToArray($args, $args['initial_dir'], $filter);
    }
}
