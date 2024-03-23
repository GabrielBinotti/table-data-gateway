<?php
namespace GabrielBinottiDatabase\interfaces;

/**
 * Interface defining methods for a database connection.
 */
interface InterfaceConnection
{
    /**
     * Initializes the database connection.
     * @param string $database The name of the database to connect to.
     */
    public static function init(String $database);

    /**
     * Gets the PDO object representing the database connection.
     * @return PDO The PDO object representing the database connection.
     */
    public static function get();

    /**
     * Begins a transaction on the current connection.
     */
    public static function transaction();

    /**
     * Commits the current transaction.
     */
    public static function commit();

    /**
     * Rolls back the current transaction.
     */
    public static function rollback();

    /**
     * Closes the current database connection.
     */
    public static function close();
}