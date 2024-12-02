<?php
class Conexion
{
    private static $conexion;

    private function __construct() { }

    public static function getConexion()
    {
        if (!self::$conexion) {
            $config = include('config.php'); // Importa la configuración
            self::$conexion = new mysqli(
                $config['host'],
                $config['usuario'],
                $config['password'],
                $config['base_datos']
            );

            if (self::$conexion->connect_error) {
                die("Error de conexión a la base de datos: " . self::$conexion->connect_error);
            }

            self::$conexion->set_charset("utf8");
        }

        return self::$conexion;
    }
}
?>