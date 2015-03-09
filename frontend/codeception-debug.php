<?php
require "C:/Users/mgh14/AppData/Roaming/Composer/vendor/autoload.php";
//spl_autoload_register('application_autoloader');

/**
 * Codeception PHP script runner
 */
use Symfony\Component\Console\Application;

$app = new Application('Codeception', Codeception\Codecept::VERSION);
$app->add(new Codeception\Command\Run('run'));

$app->run();

// AUTOLOADER FUNCTION
function application_autoloader($class) {
    $class = strtolower($class);
    $class_filename = strtolower($class).'.php';
    $class_root = realpath(__DIR__ . '/../..');
    $cache_file = "{$class_root}/cache/classpaths.cache";
    $path_cache = (file_exists($cache_file)) ? unserialize(file_get_contents($cache_file)) : array();
    if (!is_array($path_cache)) { $path_cache = array(); }

    if (array_key_exists($class, $path_cache)) {
        /* Load class using path from cache file (if the file still exists) */
        if (file_exists($path_cache[$class])) { require_once $path_cache[$class]; }

    } else {
        /* Determine the location of the file within the $class_root and, if found, load and cache it */
        $directories = new RecursiveDirectoryIterator($class_root);
        foreach(new RecursiveIteratorIterator($directories) as $file) {
            if (strtolower($file->getFilename()) == $class_filename) {
                $full_path = $file->getRealPath();
                $path_cache[$class] = $full_path;
                require_once $full_path;
                break;
            }
        }

    }

    $serialized_paths = serialize($path_cache);
    if ($serialized_paths != $path_cache) { file_put_contents($cache_file, $serialized_paths); }
}