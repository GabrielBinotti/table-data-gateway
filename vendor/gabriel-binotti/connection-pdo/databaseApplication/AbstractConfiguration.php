<?php

namespace GabrielBinottiDatabase;

/**
 * Abstract Class defining methods for setting up a connection database
 */
abstract class AbstractConfiguration
{
    /**
     * Abstract method responsible for configuring the database
     * @param string $database is the file name.
     */
    abstract protected function configurationDatabase(String $database);

    /**
     * Abstract method responsible for configuring dsn (data source name)
     * @param array $file is the array with data to set the dsn
     */
    abstract protected function dsnConfiguration(array $file);
}
