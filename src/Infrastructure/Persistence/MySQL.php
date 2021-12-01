<?php

namespace AMSGuitars\Infrastructure\Persistence;

use mysqli;

class MySQL
{
    private static mysqli $mysqli;

    public static function getConnection(): mysqli
    {
        if (!isset(self::$mysqli)) {
            self::$mysqli = new mysqli(
                $_ENV['MYSQL_HOST'],
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_PASSWORD'],
                null,
                $_ENV['MYSQL_PORT'],
                $_ENV['MYSQL_SOCKET']
            );
        }

        return self::$mysqli;
    }

    public static function selectDatabase(string $database): void
    {
        self::$mysqli->select_db($database);
    }

    public static function createDatabase(): void
    {
        shell_exec('mysql -u'.$_ENV['MYSQL_ROOT_USER'].' -p'.$_ENV['MYSQL_ROOT_PASSWORD'].' -e"CREATE DATABASE '.$_ENV['MYSQL_DATABASE'].'" 2>/dev/null');
    }

    public static function createStructure(): void
    {
        shell_exec('mysql -u'.$_ENV['MYSQL_ROOT_USER'].' -p'.$_ENV['MYSQL_ROOT_PASSWORD'].' '.$_ENV['MYSQL_DATABASE'].' < '.__DIR__.'/../../../sql/structure.sql 2>/dev/null');
    }

    public static function dropDatabase(): void
    {
        shell_exec('mysql -u'.$_ENV['MYSQL_ROOT_USER'].' -p'.$_ENV['MYSQL_ROOT_PASSWORD'].' -e"DROP DATABASE '.$_ENV['MYSQL_DATABASE'].'" 2>/dev/null');
    }
}