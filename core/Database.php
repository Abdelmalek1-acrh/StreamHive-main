<?php

/**
 * Database Singleton Class
 * Manages the PDO database connection
 */
class Database
{
    private static ?PDO $instance = null;

    private const HOST = 'localhost';
    private const DBNAME = 'streamhive';
    private const USERNAME = 'root';
    private const PASSWORD = '';

    /**
     * Get the singleton PDO instance
     * 
     * @return PDO The database connection
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    "mysql:host=" . self::HOST . ";dbname=" . self::DBNAME . ";charset=utf8mb4",
                    self::USERNAME,
                    self::PASSWORD
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct()
    {
    }

    /**
     * Prevent cloning of the instance
     */
    private function __clone()
    {
    }

    /**
     * Prevent unserialization of the instance
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}
