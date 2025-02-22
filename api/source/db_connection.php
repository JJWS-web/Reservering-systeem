<?php

class ToanoConnect {
      /**
     *  declares 3 private static properties that are used to store the config file
     * and an array to store the config settings and a pdo object to store the connection
     */
    private static $configFile = __DIR__ . '/../config.ini';
    private static $config;
    private static $pdo;

      /**
     * checks if the config file exists and if it does not it throws an exception 
     * if it does it parses the config file and stores the values in the config array
     * it then gets the values for the database connection and stores them in variables
     * and then makesa connection to the database.
     */
    public static function connect() {
        if (!file_exists(self::$configFile)) {
            throw new Exception("Configuration file not found: " . self::$configFile);
        }

        self::$config = parse_ini_file(self::$configFile, true);

        if (self::$config === false) {
            throw new Exception("Failed to parse configuration file: " . self::$configFile);
        }

        $dbHost = self::$config['database']['host'];
        $dbPort = self::$config['database']['port'];
        $dbName = self::$config['database']['name'];
        $dbUser = self::$config['database']['user'];
        $dbPassword = self::$config['database']['password'];

        try {
            self::$pdo = new PDO("mysql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           // echo "Database connection successful!";
            return self::$pdo;
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }
      /**
     * returns the parsed config array
     */
    public static function getConfig() {
        return self::$config;
    }
}