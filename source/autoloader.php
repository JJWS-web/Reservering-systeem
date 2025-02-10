<?php
class ToanoLoader {
    public function __construct()
    {
        $this->app_Loader();
        $this->loadConnection();
        $this->source_Loader();
    }
   #Loads all classes in the app folder
    public function app_Loader() {
        $loader = spl_autoload_register(function ($class) {
            $filePath = __DIR__ . '/app/' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($filePath)) {
                require_once $filePath;
            } else {
                error_log("Class file for {$class} cannot be found at {$filePath}");
            }
        });
    }

    public function source_Loader() {
        $loader = spl_autoload_register(function ($class) {
            $filePath = __DIR__ . '/source/' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($filePath)) {
                require_once $filePath;
            } else {
                error_log("Class file for {$class} cannot be found at {$filePath}");
            }
        });
    }
    #Loads the db_connection.php file when called upon
    public function loadConnection() {
        $this->loadDBConnection();
    }
    private function loadDBConnection() {
        require_once __DIR__ . '/db_connection.php';
    }
}