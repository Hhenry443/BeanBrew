<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitbba07e1bad99e28ae77f9fba9d0a2730
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitbba07e1bad99e28ae77f9fba9d0a2730', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitbba07e1bad99e28ae77f9fba9d0a2730', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitbba07e1bad99e28ae77f9fba9d0a2730::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
