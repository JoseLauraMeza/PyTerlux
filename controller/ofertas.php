<?php
require_once(__DIR__ . '/../models/ofertas.php');

class OfertaControlador
{
    private $model;

    public function __construct()
    {
        $this->model = new Ofertas();  // Instancia del modelo de ofertas
    }

    // Método para crear una nueva oferta
    public function crearOferta($empresa_id, $titulo, $descripcion, $requisitos, $ubicacion, $salario, $categoria_id)
    {
        if (empty($titulo) || empty($descripcion) || empty($requisitos) || empty($ubicacion) || empty($salario) || empty($categoria_id)) {
            return "Por favor, completa todos los campos.";
        }

        $resultado = $this->model->crearOferta($empresa_id, $titulo, $descripcion, $requisitos, $ubicacion, $salario, $categoria_id);

        if ($resultado) {
            return "Oferta creada exitosamente.";
        } else {
            return "Hubo un error al crear la oferta. Intenta nuevamente.";
        }
    }

    // Método para obtener todas las ofertas de una empresa
    public function obtenerOfertasPorEmpresa($empresa_id)
    {
        return $this->model->obtenerOfertasPorEmpresa($empresa_id);
    }

    // Método para obtener una oferta específica
    public function obtenerOfertaPorId($oferta_id)
    {
        return $this->model->obtenerOfertaPorId($oferta_id);
    }

    // Método para actualizar una oferta
    public function actualizarOferta($oferta_id, $titulo, $descripcion, $requisitos, $ubicacion, $salario)
    {
        if (empty($titulo) || empty($descripcion) || empty($requisitos) || empty($ubicacion) || empty($salario)) {
            return "Por favor, completa todos los campos.";
        }

        $resultado = $this->model->actualizarOferta($oferta_id, $titulo, $descripcion, $requisitos, $ubicacion, $salario);

        if ($resultado) {
            return "Oferta actualizada exitosamente.";
        } else {
            return "Hubo un error al actualizar la oferta. Intenta nuevamente.";
        }
    }

    // Método para eliminar una oferta
    public function eliminarOferta($oferta_id)
    {
        $resultado = $this->model->eliminarOferta($oferta_id);

        if ($resultado) {
            return "Oferta eliminada exitosamente.";
        } else {
            return "Hubo un error al eliminar la oferta.";
        }
    }

    // Método para obtener categorías (para mostrarlas en formularios)
    public function obtenerCategorias()
    {
        return $this->model->obtenerCategorias();
    }
}
?>
