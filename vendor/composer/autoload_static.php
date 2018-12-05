<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4a07b6a84847c0489df32ab5499fd5a6
{
    public static $classMap = array (
        'AYLIEN\\TextAPI' => __DIR__ . '/..' . '/aylien/textapi/src/AYLIEN/TextAPI.php',
        'AYLIEN\\TextAPI\\IO_Abstract' => __DIR__ . '/..' . '/aylien/textapi/src/AYLIEN/IO/Abstract.php',
        'AYLIEN\\TextAPI\\IO_Curl' => __DIR__ . '/..' . '/aylien/textapi/src/AYLIEN/IO/Curl.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit4a07b6a84847c0489df32ab5499fd5a6::$classMap;

        }, null, ClassLoader::class);
    }
}
