<?php
namespace AgenciaPublicidad\Models\dataBase;

require_once __DIR__ . '/../../config/config.php';

class DBCon {
    private static $DBconn = null;

    public static function getConnection() {
        if (!self::$DBconn) {
            try {
                $port = defined('PORT') ? PORT : '3306';
                $dsn = 'mysql:host=' . HOST . ';port=' . $port . ';dbname=' . DB_NAME . ';charset=utf8mb4';
                $options = DB_OPTIONS;
                self::$DBconn = new \PDO($dsn, USER, PASS, $options);
            } catch (\PDOException $ex) {
                // En producción, registra el error y muestra un mensaje genérico
                throw new \RuntimeException('Error de conexión a la base de datos: ' . $ex->getMessage(), 0, $ex);
            }
        }
        return self::$DBconn;
    }
}
?>