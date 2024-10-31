<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6d6569ba8a08207fd0fc0ff497f89c23
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Easymailing\\App\\' => 16,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Easymailing\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6d6569ba8a08207fd0fc0ff497f89c23::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6d6569ba8a08207fd0fc0ff497f89c23::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6d6569ba8a08207fd0fc0ff497f89c23::$classMap;

        }, null, ClassLoader::class);
    }
}
