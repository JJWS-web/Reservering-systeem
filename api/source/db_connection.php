<?php

class ToanoConnect {
    private static $configFile = 'config.ini';
    private static $config;
    private static $pdo;

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

    public static function getConfig() {
        return self::$config;
    }
}