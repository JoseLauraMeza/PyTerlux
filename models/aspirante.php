<?php
require_once 'Conexion.php';

class AspiranteModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::getConexion();
    }

    // Método para obtener datos del aspirante por usuario_id
    public function obtenerPorUsuarioId($usuario_id)
    {
        $sql = "SELECT * FROM Candidatos WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Método para actualizar datos del aspirante
    public function actualizar($usuario_id, $nombre_completo, $fecha_nacimiento, $genero, $ubicacion, $telefono)
    {
        $sql = "UPDATE Candidatos SET nombre_completo = ?, fecha_nacimiento = ?, genero = ?, ubicacion = ?, telefono = ? 
                WHERE usuario_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssssi", $nombre_completo, $fecha_nacimiento, $genero, $ubicacion, $telefono, $usuario_id);

        return $stmt->execute();
    }
}
?>