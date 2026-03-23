<a href="../pages/noticia.php?id=<?= $noticia['id'] ?>&origen=<?= $categoria ?? 'noticias' ?>" class="card-link">

<div class="card card-noticia">

    <div class="card-imagen"
        style="background-image:url('../assets/img/noticias/<?= $noticia['imagen'] ?>')">
    </div>

    <div class="card-body">

        <h3 class="noticia-titulo">
            <?= $noticia['titulo'] ?>
        </h3>

        <small class="noticia-fecha">
            <?= $noticia['fecha'] ?>
        </small>

        <p class="noticia-texto">
            <?= substr($noticia['texto'],0,140) ?>...
        </p>

    </div>

</div>

</a>