<?php

namespace App\Services;

use App\Core\Database;
use App\Services\UploadService;

// SERVICIO ENCARGADO DE LA LÓGICA DE NEGOCIO RELACIONADA CON LAS PRENDAS ( catálogo, creación, filtrado, etc. )

class PrendaService
{
    private $prendaModel;

    public function __construct()
    {
        $this->prendaModel = new \App\Models\PrendaModel();
    }

    // OBTENER CATÁLOGO DE PRENDAS PUBLICADAS ( EXCLUYENDO LAS DEL USUARIO LOGEADO )

    public function obtenerCatalogo($usuarioId)
    {
        return $this->prendaModel
            ->obtenerPublicadas($usuarioId);
    }

    // OBTENER PRENDAS DEL USUARIO SEGÚN SU ESTADO ( EN VENTA, VENDIDAS, PENDIENTES, RECHAZADAS )
    public function obtenerMisVentas($usuarioId)
    {
        return [
            'enVenta' => $this->prendaModel
                ->obtenerPorUsuarioYEstado($usuarioId, 'publicada'),

            'vendidas' => $this->prendaModel
                ->obtenerPorUsuarioYEstado($usuarioId, 'vendida'),

            'pendientes' => $this->prendaModel
                ->obtenerPorUsuarioYEstado($usuarioId, 'pendiente'),

            'rechazadas' => $this->prendaModel
                ->obtenerPorUsuarioYEstado($usuarioId, 'rechazada'),
        ];
    }

    // OBTENER DATOS NECESARIOS PARA EL FORMULARIO DE CREACIÓN DE PRENDA ( TIPOS, COLEGIOS, ESTADOS, TALLAS, GÉNEROS )

    public function obtenerDatosFormulario($colegioSeleccionado = null)
    {
        $pdo = Database::getConnection();

        // Si se ha seleccionado un colegio, solo mostrar los tipos de prenda asociados a ese colegio. Si no, mostrar todos los tipos.
        
        if ($colegioSeleccionado) {
            $stmt = $pdo->prepare("
                SELECT tp.id, tp.nombre
                FROM tipos_prenda tp
                JOIN colegio_tipo_prenda ctp 
                ON tp.id = ctp.tipo_prenda_id
                WHERE ctp.colegio_id = :colegio
            ");

            $stmt->execute(['colegio' => $colegioSeleccionado]);
            $tiposPrenda = $stmt->fetchAll();
        } else {
            $tiposPrenda = $pdo->query('SELECT id, nombre FROM tipos_prenda')->fetchAll();
        }

        return [
            'tiposPrenda' => $tiposPrenda,
            'colegios' => $pdo->query('SELECT id, nombre FROM colegios')->fetchAll(),
            'estados' => $pdo->query('SELECT id, nombre FROM estados_calidad')->fetchAll(),
            'tallas' => $pdo->query('SELECT id, nombre FROM tallas ORDER BY id')->fetchAll(),
            'generos' => $pdo->query('SELECT id, nombre FROM generos')->fetchAll(),
        ];
    }

    // CREAR NUEVA PRENDA ( validación de datos, subida de imagen, cálculo de precio )

    public function crearPrenda($data, $file, $usuario_id)
    {

        // Validar campos obligatorios

        $campos = ['tipoPrenda', 'colegio', 'estadoPrenda', 'talla', 'genero'];

        foreach ($campos as $campo) {
            if (empty($data[$campo])) {
                throw new \Exception("El campo {$campo} es obligatorio");
            }
        }

        // Validar tipos numéricos

        foreach ($campos as $campo) {
            if (!is_numeric($data[$campo])) {
                throw new \Exception("Datos inválidos en {$campo}");
            }
        }

        // Convertir a enteros ( seguridad extra )

        $tipo = (int) $data['tipoPrenda'];
        $colegio = (int) $data['colegio'];
        $estado = (int) $data['estadoPrenda'];
        $talla = (int) $data['talla'];
        $genero = (int) $data['genero'];

        // Validar relación tipo ↔ colegio

        if (
            !$this->prendaModel
                ->existeRelacionTipoColegio($colegio, $tipo)
        ) {
            throw new \Exception('Esa prenda no pertenece a ese colegio');
        }

        // Obtener precio 

        $precio = $this->prendaModel
            ->obtenerPrecio($tipo, $estado);

        // Subir imagen 

        $uploadService = new UploadService();
        $imagenRuta = $uploadService->subir($file);

        // Guardar en BD con control de errores

        try {
            $this->prendaModel->crear([
                'usuario_id' => $usuario_id,
                'tipo_prenda_id' => $tipo,
                'colegio_id' => $colegio,
                'estado_calidad_id' => $estado,
                'precio' => $precio,
                'talla_id' => $talla,
                'genero_id' => $genero,
                'imagen' => $imagenRuta,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Error al guardar la prenda en la base de datos');
        }
    }

    // FILTRAR PRENDAS EN EL CATÁLOGO SEGÚN COLEGIO, TIPO Y ESTADO ( CONSIDERANDO SOLO LAS PRENDAS DE OTROS USUARIOS )
    
    public function filtrar($colegio, $tipo, $estado, $usuarioId)
    {
        return $this->prendaModel
            ->filtrar($colegio, $tipo, $estado, $usuarioId);
    }
}
