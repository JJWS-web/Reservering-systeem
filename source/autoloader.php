<?php

class ToanoLoader {

    private $classMap = [
        'ToanoUser' => 'user.php',
        // Add other class mappings here if needed
    ];

    public function __construct()
    {
        $this->loader();
        $this->loadConnection();
    }

    # Loads all classes in the app folder
    public function loader() {
        spl_autoload_register(function ($class) {
            if (isset($this->classMap[$class])) {
                $filePath = __DIR__ . '/../app/' . $this->classMap[$class];
            } else {
                $filePath = __DIR__ . '/../app/' . $class . '.php';
            }

            if (file_exists($filePath)) {
                require_once $filePath;
            } else {
                error_log("Class file for {$class} cannot be found at {$filePath}");
            }
        });
    }

    # Loads the db_connection.php file when called upon
    public function loadConnection() {
        $this->loadDBConnection();
    }

    private function loadDBConnection() {
        require_once __DIR__ . '/db_connection.php';
    }
}