<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit479d381368da1a775681e42a46c9e0a4
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Intervention\\Image\\' => 19,
            'Intervention\\Gif\\' => 17,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Intervention\\Image\\' => 
        array (
            0 => __DIR__ . '/..' . '/intervention/image/src',
        ),
        'Intervention\\Gif\\' => 
        array (
            0 => __DIR__ . '/..' . '/intervention/gif/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit479d381368da1a775681e42a46c9e0a4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit479d381368da1a775681e42a46c9e0a4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit479d381368da1a775681e42a46c9e0a4::$classMap;

        }, null, ClassLoader::class);
    }
}
