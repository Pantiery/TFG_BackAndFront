<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4 mb-4 text-center">
    <form method="POST" action="/proyecto_TFG/TFG_BackAndFront/public/register" class="grid-layout">

        <h2>Solicitar venta</h2>

        <label>Nombre del colegio</label>
        <select name="colegios" id="colegio" required>
            <option disabled selected>--Selecciona un colegio--</option>
            <option>IES Gabriel García Márquez</option>
            <option>IES Pedro Duque</option>
        </select>

        <label>Tipo de prenda</label>
        <select name="prendas" id="prenda" required>
            <option disabled selected>--Selecciona una prenda--</option>
            <option value="1">Polo</option>
            <option value="2">Pantalón corto</option>
            <option value="3">Falda</option>
            <option value="4">Sudadera</option>
        </select>

        <label>Género</label>
        <select name="genero" id="genero" required>
            <option disabled selected>--Selecciona un genero--</option>
            <option>Chico</option>
            <option>Chica</option>
        </select>

        <label>Talla</label>
        <select name="tallas" id="talla" required>
            <option disabled selected>--Selecciona una talla--</option>
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>
        </select>

        <label>Estado</label>
        <select name="estados" id="estado" required>
            <option disabled selected>--Selecciona el estado de la prenda--</option>
            <option>Nuevo</option>
            <option>Usado</option>
            <option>Muy usado</option>
        </select>

        <button type="submit" class="btn btn-primary">Solicitar venta</button>

    </form>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>