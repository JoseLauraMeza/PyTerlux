<?php
require_once 'Conexion.php';

class EmpresaModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::getConexion();
    }

    // Método para insertar una nueva empresa
    public function insertar($usuario_id, $nombre_empresa, $descripcion, $ubicacion, $sitio_web)
    {
        $sql = "INSERT INTO Empresas (usuario_id, nombre_empresa, descripcion, ubicacion, sitio_web) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("issss", $usuario_id, $nombre_empresa, $descripcion, $ubicacion, $sitio_web);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerEmpresaPorId($empresa_id)
    {
        $sql = "SELECT * FROM empresas WHERE empresa_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $empresa_id); // 'i' indica que el parámetro es un entero
        $stmt->execute();
        $result = $stmt->get_result();

        // Si encuentra un registro, devuelve el resultado como un array asociativo
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Si no encuentra la empresa, devuelve null
        }
    }

    // Método para buscar una empresa por ID de usuario
    public function buscarPorUsuarioId($usuario_id)
    {
        $sql = "SELECT * FROM Empresas WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Método para actualizar la información de una empresa
    public function actualizar($usuario_id, $nombre_empresa, $descripcion, $ubicacion, $sitio_web)
    {
        $sql = "UPDATE Empresas SET nombre_empresa = ?, descripcion = ?, ubicacion = ?, sitio_web = ? 
                WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre_empresa, $descripcion, $ubicacion, $sitio_web, $usuario_id);

        return $stmt->execute();
    }
}
?>
