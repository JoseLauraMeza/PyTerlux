<?php
require_once(__DIR__ . '/../models/postulacion.php');

class PostulacionController {
    private $model;

    public function __construct() {
        $this->model = new PostulacionModel();
    }

    /**
     * Verifica si el usuario ha postulado a una oferta.
     *
     * @param int $usuario_id
     * @param int $oferta_id
     * @return bool
     */
    public function haPostulado($usuario_id, $oferta_id) {
        return $this->model->haPostulado($usuario_id, $oferta_id);
    }

    /**
     * Registra una postulación para un usuario.
     *
     * @param int $usuario_id
     * @param int $oferta_id
     * @return bool
     */
    public function registrarPostulacion($usuario_id, $oferta_id) {
        if (!$this->haPostulado($usuario_id, $oferta_id)) {
            return $this->model->registrarPostulacion($usuario_id, $oferta_id);
        }
        return false; // Ya ha postulado
    }
}
