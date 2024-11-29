<?php
require_once 'Conexion.php';

class UsuarioModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::getConexion();
    }

    public function insertar($nombre, $email, $contrasena, $tipo_usuario)
    {
        $sql = "INSERT INTO Usuarios (nombre, email, contrasena, tipo_usuario) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt->bind_param("ssss", $nombre, $email, $hashed_password, $tipo_usuario);

        if ($stmt->execute()) {
            return $this->conexion->insert_id;
        } else {
            return false;
        }
    }

    public function buscarPorEmail($email)
    {
        $sql = "SELECT * FROM Usuarios WHERE email = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
