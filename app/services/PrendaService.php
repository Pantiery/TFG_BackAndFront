<?php

namespace App\Services;

use App\Core\Database;
use App\Services\UploadService;

// Servicio para manejar la lógica relacionada con las prendas ( creación, validación, filtrado, etc. )
class PrendaService
{
    private $prendaModel;

    public function __construct()
    {
        $this->prendaModel = new \App\Models\PrendaModel();
    }

    // Obtener prendas publicadas para el catálogo ( excluyendo las del usuario logeado )
    public function obtenerCatalogo($usuarioId)
    {
        return $this->prendaModel
            ->obtenerPublicadas($usuarioId);
    }

    // Obtener prendas del usuario según su estado ( en venta, vendidas, pendientes, rechazadas )
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

    // Obtener datos necesarios para el formulario de creación de prenda ( tipos, colegios, estados, tallas, géneros )

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

    // Crear una nueva prenda con validación de datos, subida de imagen y manejo de errores

    public function crearPrenda($data, $file, $usuario_id)
    {

        // 1. Validar campos obligatorios
        $campos = ['tipoPrenda', 'colegio', 'estadoPrenda', 'talla', 'genero'];

        foreach ($campos as $campo) {
            if (empty($data[$campo])) {
                throw new \Exception("El campo {$campo} es obligatorio");
            }
        }

        // 2. Validar tipos numéricos
        foreach ($campos as $campo) {
            if (!is_numeric($data[$campo])) {
                throw new \Exception("Datos inválidos en {$campo}");
            }
        }

        // 3. Convertir a enteros ( seguridad extra )
        $tipo = (int) $data['tipoPrenda'];
        $colegio = (int) $data['colegio'];
        $estado = (int) $data['estadoPrenda'];
        $talla = (int) $data['talla'];
        $genero = (int) $data['genero'];

        // 4. Validar relación tipo ↔ colegio
        if (
            !$this->prendaModel
                ->existeRelacionTipoColegio($colegio, $tipo)
        ) {
            throw new \Exception('Esa prenda no pertenece a ese colegio');
        }

        // 5. Obtener precio ( ya valida internamente )
        $precio = $this->prendaModel
            ->obtenerPrecio($tipo, $estado);

        // 6. Subir imagen ( puede lanzar excepción )
        $uploadService = new UploadService();
        $imagenRuta = $uploadService->subir($file);

        // 7. Guardar en BD con control de errores
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

    // Filtrar prendas en el catálogo según colegio, tipo y estado de calidad ( excluyendo las del usuario logeado )
    public function filtrar($colegio, $tipo, $estado, $usuarioId)
    {
        return $this->prendaModel
            ->filtrar($colegio, $tipo, $estado, $usuarioId);
    }
}
