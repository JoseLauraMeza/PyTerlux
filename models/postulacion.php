<?php
require_once 'conexion.php';

class PostulacionModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::getConexion();  // Conexión inicializada correctamente
    }

    /**
     * Verifica si el usuario ya ha postulado a una oferta.
     *
     * @param int $usuario_id
     * @param int $oferta_id
     * @return bool
     */
    public function haPostulado($usuario_id, $oferta_id) {
        $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM postulaciones WHERE candidato_id = ? AND oferta_id = ?"); // Ajusta los nombres de columna si es necesario
        $stmt->bind_param("ii", $usuario_id, $oferta_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count > 0;
    }

    /**
     * Registra una nueva postulación en la base de datos con estado 'pendiente'.
     *
     * @param int $usuario_id
     * @param int $oferta_id
     * @return bool
     */
    public function registrarPostulacion($usuario_id, $oferta_id) {
        $estado = 'pendiente';  // Estado predeterminado
        $stmt = $this->conexion->prepare("INSERT INTO postulaciones (candidato_id, oferta_id, fecha_postulacion, estado) VALUES (?, ?, NOW(), ?)");
        $stmt->bind_param("iis", $usuario_id, $oferta_id, $estado);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
