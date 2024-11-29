<?php
require_once 'conexion.php';

class Ofertas
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::getConexion();  // Conexión inicializada correctamente
    }

    public function crearOferta($empresa_id, $titulo, $descripcion, $requisitos, $ubicacion, $salario, $categoria_id)
{
    // Insertar la oferta en la tabla Ofertas
    $sql = "INSERT INTO Ofertas (empresa_id, titulo, descripcion, requisitos, ubicacion, salario) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("issssd", $empresa_id, $titulo, $descripcion, $requisitos, $ubicacion, $salario);
    $resultado = $stmt->execute();

    // Verificar si la oferta se creó correctamente
    if ($resultado) {
        // Obtener el ID de la oferta recién creada
        $oferta_id = $this->conexion->insert_id;

        // Ahora insertamos el registro en la tabla OfertaCategoria
        $sql_categoria = "INSERT INTO OfertaCategoria (oferta_id, categoria_id) 
                          VALUES (?, ?)";
        $stmt_categoria = $this->conexion->prepare($sql_categoria);
        $stmt_categoria->bind_param("ii", $oferta_id, $categoria_id);
        
        // Ejecutar la inserción en la tabla de relación
        return $stmt_categoria->execute();
    }

    return false;  // Si hubo un error al insertar la oferta
}


    public function obtenerCategorias()
    {
        $sql = "SELECT * FROM Categorias";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener todas las ofertas de una empresa
    public function obtenerOfertasPorEmpresa($empresa_id)
    {
        $sql = "SELECT * FROM Ofertas WHERE empresa_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $empresa_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener una oferta específica
    public function obtenerOfertaPorId($oferta_id)
    {
        $sql = "SELECT * FROM Ofertas WHERE oferta_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $oferta_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Actualizar una oferta
    public function actualizarOferta($oferta_id, $titulo, $descripcion, $requisitos, $ubicacion, $salario)
    {
        $sql = "UPDATE Ofertas SET titulo = ?, descripcion = ?, requisitos = ?, ubicacion = ?, salario = ? 
                WHERE oferta_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssssdi", $titulo, $descripcion, $requisitos, $ubicacion, $salario, $oferta_id);
        return $stmt->execute();
    }

    // Eliminar una oferta
    public function eliminarOferta($oferta_id)
    {
        $sql = "DELETE FROM Ofertas WHERE oferta_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $oferta_id);
        return $stmt->execute();
    }


    public function obtenerOfertasActivas($limite)
    {
        $sql = "SELECT * FROM Ofertas WHERE estado = 'activa' ORDER BY fecha_publicacion DESC LIMIT ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $limite);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
}
?>
