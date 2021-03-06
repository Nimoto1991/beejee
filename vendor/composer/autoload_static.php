<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitca8ce260a125946b44adf33a80f0905e
{
    public static $classMap = array (
        'beejee\\assets\\AssetBundle' => __DIR__ . '/../..' . '/assets/AssetBundle.php',
        'beejee\\controllers\\AdminController' => __DIR__ . '/../..' . '/controllers/AdminController.php',
        'beejee\\controllers\\SiteController' => __DIR__ . '/../..' . '/controllers/SiteController.php',
        'beejee\\controllers\\TaskController' => __DIR__ . '/../..' . '/controllers/TaskController.php',
        'beejee\\core\\Application' => __DIR__ . '/../..' . '/core/Application.php',
        'beejee\\core\\Asset' => __DIR__ . '/../..' . '/core/Asset.php',
        'beejee\\core\\Controller' => __DIR__ . '/../..' . '/core/Controller.php',
        'beejee\\core\\DataBaseConnection' => __DIR__ . '/../..' . '/core/DataBaseConnection.php',
        'beejee\\core\\Router' => __DIR__ . '/../..' . '/core/Router.php',
        'beejee\\core\\Validator' => __DIR__ . '/../..' . '/core/Validator.php',
        'beejee\\core\\View' => __DIR__ . '/../..' . '/core/View.php',
        'beejee\\models\\Admin' => __DIR__ . '/../..' . '/models/Admin.php',
        'beejee\\models\\Task' => __DIR__ . '/../..' . '/models/Task.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitca8ce260a125946b44adf33a80f0905e::$classMap;

        }, null, ClassLoader::class);
    }
}
