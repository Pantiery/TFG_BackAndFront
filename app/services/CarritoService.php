<?php

namespace App\Services;

use App\Models\CarritoModel;

class CarritoService
{
    private $carritoModel;

    public function __construct()
    {
        $this->carritoModel = new CarritoModel();
    }

    // Obtener carrito por usuario
    public function getByUserId($usuarioId)
    {
        return $this->carritoModel->getByUserId($usuarioId);
    }

    // Crear carrito
    public function create($usuarioId)
    {
        return [
            'id' => $this->carritoModel->create($usuarioId)
        ];
    }

    // Añadir prenda al carrito

    public function addItem($carritoId, $prendaId)
    {
        // comprobar si la prenda ya está vendida
        $estado = $this->carritoModel
            ->getEstadoPrenda($prendaId);

        if ($estado === 'vendida') {
            return false;
            // no permitir añadir
        }
        // comprobar si ya existe
        $existe = $this->carritoModel
            ->itemExiste($carritoId, $prendaId);

        if ($existe) {
            return false;
            // ya está en carrito
        }

        // insertar si no existe
        return $this->carritoModel->addItem($carritoId, $prendaId);
    }

    // Obtener productos del carrito
    public function getItems($carritoId)
    {
        return $this->carritoModel->getItems($carritoId);
    }

    // Obtener items del carrito por usuario

    public function getItemsByUser($usuarioId)
    {
        // 1. Obtener carrito del usuario
        $carrito = $this->getByUserId($usuarioId);

        // 2. Si no tiene carrito → devolver vacío
        if (!$carrito) {
            return [];
        }

        // 3. Obtener items del carrito
        return $this->getItems($carrito['id']);
    }

    // Eliminar item del carrito
    public function removeItem($carritoId, $prendaId)
    {
        return $this->carritoModel
            ->removeItem($carritoId, $prendaId);
    }

    // Vaciar carrito
    public function vaciarCarrito($carritoId)
    {
        return $this->carritoModel->vaciarCarrito($carritoId);
    }
}
