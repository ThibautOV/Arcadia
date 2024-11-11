<?php
spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
    $file = __DIR__ . '/controllers/' . $class_name . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        $file = __DIR__ . '/models/' . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            $file = __DIR__ . '/config/' . $class_name . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }
});
?>