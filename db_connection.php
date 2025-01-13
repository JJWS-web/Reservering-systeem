<?php

class ToanoConnect {

    private $configFile = 'config.ini';
    private $config;

    public function __construct()
    {   
        $this->connect();
    }
   
    private function connect()
    {
        if (!file_exists($this->configFile)) {
            throw new Exception("Configuration file not found: " . $this->configFile);
        }

        $this->config = parse_ini_file($this->configFile, true);

        if ($this->config === false) {
            throw new Exception("Failed to parse configuration file: " . $this->configFile);
        }

        $dbHost = $this->config['database']['host'];
        $dbPort = $this->config['database']['port'];
        $dbName = $this->config['database']['name'];
        $dbUser = $this->config['database']['user'];
        $dbPassword = $this->config['database']['password'];

        try {
            $dbh = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo "Database connection successful!";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    }
    
    public function getConfig()
    {
        return $this->config;
    }
}

?>
