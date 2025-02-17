<?php

class ToanoLoader {
    public function __construct() {
        $this->registerClassLoader();
        $this->loadDBConnection();
    }

    /**
     * Registers the class autoloader for the application.
     */
    private function registerClassLoader() {
        spl_autoload_register(function ($class) {
            $filePath = __DIR__ . '/../app/' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($filePath)) {
                require_once $filePath;
            } else {
                error_log("Class file for {$class} cannot be found at {$filePath}");
            }
        });
    }

    /**
     * Loads the database connection file if it exists.
     */
    private function loadDBConnection() {
        $dbFilePath = __DIR__ . '/db_connection.php';
        if (file_exists($dbFilePath)) {
            require_once $dbFilePath;
        } else {
            error_log("Database connection file not found at {$dbFilePath}");
        }
    }
}