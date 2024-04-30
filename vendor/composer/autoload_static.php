<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8c11f1b49bc138ec5e5f4bbcfc7c1ca9
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'NestPHP\\' => 8,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'NestPHP\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8c11f1b49bc138ec5e5f4bbcfc7c1ca9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8c11f1b49bc138ec5e5f4bbcfc7c1ca9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8c11f1b49bc138ec5e5f4bbcfc7c1ca9::$classMap;

        }, null, ClassLoader::class);
    }
}