<?php

$archivo = __DIR__ . '/../data/noticias.json';

if(file_exists($archivo)){
    $noticias = json_decode(file_get_contents($archivo), true);
}else{
    $noticias = [];
}

/* ordenar por fecha */

usort($noticias, function($a,$b){
    return strtotime($b['fecha']) - strtotime($a['fecha']);
});

?>

<div class="grid-noticias">

<?php if(!empty($noticias)): ?>

    <?php foreach ($noticias as $noticia): ?>
        <?php include __DIR__.'/component-card-noticia.php'; ?>
    <?php endforeach; ?>

<?php else: ?>

<p>No hay noticias todavía.</p>

<?php endif; ?>

</div>