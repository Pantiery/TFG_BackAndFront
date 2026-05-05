document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.alert').forEach(mensaje => {
        setTimeout(() => {
            mensaje.classList.remove('show');
            mensaje.classList.add('fade');

            setTimeout(() => {
                mensaje.remove();
            }, 500);
        }, 3000);
    });

});