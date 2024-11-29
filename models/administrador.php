<?php
require_once 'Conexion.php';

class AdministradorModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Conexion())->conectar();
    }

    public function insertar($usuario_id, $rol)
    {
        $sql = "INSERT INTO Administradores (usuario_id, rol) VALUES (:usuario_id, :rol)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':rol', $rol);
        return $stmt->execute();
    }

    public function mostrar($admin_id)
    {
        $sql = "SELECT * FROM Administradores WHERE admin_id = :admin_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':admin_id', $admin_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($admin_id, $rol)
    {
        $sql = "UPDATE Administradores SET rol = :rol WHERE admin_id = :admin_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':admin_id', $admin_id);
        return $stmt->execute();
    }

    public function eliminar($admin_id)
    {
        $sql = "DELETE FROM Administradores WHERE admin_id = :admin_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':admin_id', $admin_id);
        return $stmt->execute();
    }
}
?>
