<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit959d849a1f18b01d8a844b51259f8c5a
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit959d849a1f18b01d8a844b51259f8c5a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit959d849a1f18b01d8a844b51259f8c5a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}