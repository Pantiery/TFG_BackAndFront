document.addEventListener("DOMContentLoaded", function () {

    setTimeout(function() {
        const mensaje = document.getElementById('mensajeExito');

        if (mensaje) {
            mensaje.classList.remove('show');
            mensaje.classList.add('fade');

            setTimeout(() => {
                mensaje.remove();
            }, 500);
        }
    }, 3000);

});

document.addEventListener("DOMContentLoaded", function () {

    setTimeout(function() {
        const mensaje = document.getElementById('mensajeError');

        if (mensaje) {
            mensaje.classList.remove('show');
            mensaje.classList.add('fade');

            setTimeout(() => {
                mensaje.remove();
            }, 500);
        }
    }, 3000);

});