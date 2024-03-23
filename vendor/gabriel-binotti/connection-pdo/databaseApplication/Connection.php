<?php

namespace GabrielBinottiDatabase;

use Exception;
use GabrielBinottiDatabase\interfaces\InterfaceConnection;

/**
 * Class representing a database connection.
 * This class extends AbstractConfiguration and implements InterfaceConnection.
 */
final class Connection extends AbstractConfiguration implements InterfaceConnection
{
    /**
     * Atribute that store the database connection 
     */
    protected static $pdo;

    /**
     * Construct method is abstract because the self class control the instances
     * @param string $database is the file name of archive .ini
     */
    private function __construct(String $database)
    {
        /**
         * Method to set parameters to PDO connection
         */
        $config = $this->configurationDatabase($database);
        
        try {
            self::$pdo = new \PDO($config['dsn'], $config['user'], $config['pass']);
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            self::$pdo->exec('SET NAMES utf8');
        } catch (\PDOException $e) {
            throw new Exception("Não foi possível conectar ao banco de dados. \n {$e->getMessage()}");
        }
    }

    /**
     * Static method to initialize a new Connection
     * @param string $database is the file name archive .ini
     */
    public static function init(String $database)
    {
        if (!self::$pdo) {
            new Connection($database);
        }
    }

    /**
     * Static method to return the connection
     */
    public static function get()
    {
        if (!self::$pdo) {
            throw new Exception("Não possui conexão com o banco de dados aberta.");
        }
        return self::$pdo;
    }

    /**
     * Static method to close connection
     */
    public static function close()
    {
        if (self::$pdo) {
            self::$pdo = null;
        }
    }

    /**
     * Static Method to begin transaction (create a session transaction to after commit or rollback a transaction)
     */
    public static function transaction()
    {
        if (!self::$pdo) {
            throw new Exception('Não possui conexão com o banco de dados aberta.');
        }
        self::$pdo->beginTransaction();
    }

    /**
     * Static method to commit a transaction when it is executed successfully.
     */
    public static function commit()
    {
        if (!self::$pdo) {
            throw new Exception('Não possui conexão com o banco de dados aberta.');
        }
        self::$pdo->commit();
    }


    /**
     * Static method to rollback a transaction when it is not executed successfully.
     */
    public static function rollback()
    {
        if (!self::$pdo) {
            throw new Exception('Não possui conexão com o banco de dados aberta.');
        }
        self::$pdo->rollback();
    }


    /**
     * Private methods to secure of class
     */
    private function __clone()
    {
    }

    /**
     * Protected method to set config to database connection
     * @param string $database is a file name of archive .ini
     */
    protected function configurationDatabase(String $database)
    {
        $path = dirname(__FILE__) . "/config/";

        if (!file_exists($path . $database . ".ini")) {
            throw new Exception("O arquivo <strong>$database</strong> não existe.");
        }

        $file = parse_ini_file($path . $database . ".ini");
        $config = [
            "dsn"   => $this->dsnConfiguration($file),
            "user"  => $file["DB_USER"],
            "pass"  => $file["DB_PASS"]
        ];
        return $config;
    }

    /**
     * Protected method to configure the dsn (string of connection)
     * @param array $file is a array with data to database connection
     */
    protected function dsnConfiguration(array $file)
    {
        switch (strtolower($file["DB_TYPE"])) {
            case 'mysql':
            case 'pgsql':
            case 'sqlsrv':
                return strtolower($file["DB_TYPE"]) . ":host=" . $file["DB_HOST"] . ";dbname=" . $file["DB_NAME"] . ";port=" . $file["DB_PORT"];
                break;
            default:
                throw new Exception("O atributo DB_TYPE que especifica o banco de dados não foi definido no arquivo .ini");
                break;
        }
    }
}
