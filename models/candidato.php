<?php
require_once 'Conexion.php';  // Asegúrate de incluir el archivo de la conexión

class CandidatoModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->conectar();
    }

    public function insertar($usuario_id, $nombre_completo, $fecha_nacimiento, $genero, $ubicacion, $telefono)
    {
        $sql = "INSERT INTO Candidatos (usuario_id, nombre_completo, fecha_nacimiento, genero, ubicacion, telefono)
                VALUES (:usuario_id, :nombre_completo, :fecha_nacimiento, :genero, :ubicacion, :telefono)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':nombre_completo', $nombre_completo);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':telefono', $telefono);
        return $stmt->execute();
    }

    public function mostrar($candidato_id)
    {
        $sql = "SELECT * FROM Candidatos WHERE candidato_id = :candidato_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':candidato_id', $candidato_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($candidato_id, $nombre_completo, $fecha_nacimiento, $genero, $ubicacion, $telefono)
    {
        $sql = "UPDATE Candidatos SET nombre_completo = :nombre_completo, fecha_nacimiento = :fecha_nacimiento,
                genero = :genero, ubicacion = :ubicacion, telefono = :telefono WHERE candidato_id = :candidato_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre_completo', $nombre_completo);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':candidato_id', $candidato_id);
        return $stmt->execute();
    }

    public function eliminar($candidato_id)
    {
        $sql = "DELETE FROM Candidatos WHERE candidato_id = :candidato_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':candidato_id', $candidato_id);
        return $stmt->execute();
    }
}
?>
