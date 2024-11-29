<?php
class Conexion
{
    private static $conexion;

    private function __construct() { }

    public static function getConexion()
    {
        if (!self::$conexion) {
            $host = 'localhost';  // Cambiar si es necesario
            $usuario = 'root';    // Cambiar si es necesario
            $password = '';       // Cambiar si es necesario
            $base_datos = 'bolsadetrabajo';  // Cambiar al nombre de tu base de datos

            self::$conexion = new mysqli($host, $usuario, $password, $base_datos);

            if (self::$conexion->connect_error) {
                die("Error de conexión a la base de datos: " . self::$conexion->connect_error);
            }

            // Configurar el juego de caracteres (opcional)
            self::$conexion->set_charset("utf8");
        }

        return self::$conexion;
    }
}
?>
