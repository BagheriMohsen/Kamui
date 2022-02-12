<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5f080ae6503afc23767f7bd7c78a7d5c
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mohsenbagheri\\Kamui\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mohsenbagheri\\Kamui\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5f080ae6503afc23767f7bd7c78a7d5c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5f080ae6503afc23767f7bd7c78a7d5c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5f080ae6503afc23767f7bd7c78a7d5c::$classMap;

        }, null, ClassLoader::class);
    }
}