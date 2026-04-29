<?php

namespace App\Services;

// Servicio para manejar la subida de imágenes
class UploadService
{
    public function subir($file)
    {
        if (empty($file['name'])) {
            return null;
        }

        $nombre = time() . '_' . $file['name'];
        $ruta = __DIR__ . '/../../public/uploads/' . $nombre;

        if (!move_uploaded_file($file['tmp_name'], $ruta)) {
            throw new \Exception('Error al subir imagen');
        }

        return '/uploads/' . $nombre;
    }
}
