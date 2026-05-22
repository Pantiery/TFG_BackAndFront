console.log('carrito.js cargado');
console.log(
    'formularios compra:',
    document.querySelectorAll('.form-comprar-carrito').length
);

// FUNCIONES PARA MOSTRAR TOASTS Y GESTIONAR MENSAJES DEL CARRITO
function mostrarToast(mensaje, tipo = 'success') {

    const toastContainer =
        document.getElementById('toast-container');

    const toast = document.createElement('div');

    toast.className =
        `toast align-items-center text-bg-${tipo} border-0`;

    toast.role = 'alert';

    toast.innerHTML = `
        <div class="d-flex">

            <div class="toast-body">
                ${mensaje}
            </div>

            <button
                type="button"
                class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast">
            </button>

        </div>
    `;


    toastContainer.appendChild(toast);

    const bsToast = new bootstrap.Toast(toast, {
        delay: 1800
    });

    bsToast.show();

    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

// GESTIÓN DE LOS FORMULARIOS DE AGREGAR DEL CARRITO
document.querySelectorAll('.form-carrito')

    .forEach(form => {

        form.addEventListener('submit', async e => {

            e.preventDefault();

            const datos = new FormData(form);

            try {

                const response = await fetch(form.action, {

                    method: 'POST',

                    body: datos,

                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                // Si el servidor indica que se requiere login, redirigimos al usuario a la página de login
                if (data.loginRequired) {

                    window.location.href = '/proyecto_TFG/TFG_BackAndFront/public/login';

                    return;
                }

                mostrarToast(
                    data.message,
                    data.success ? 'success' : 'danger'
                );

                if (data.totalItems !== undefined) {

                    const contador =
                        document.getElementById('contador-carrito');

                    if (contador) {
                        contador.textContent = data.totalItems;
                    }
                }

            } catch (error) {

                console.error(error);

                mostrarToast(
                    'Error inesperado',
                    'danger'
                );
            }
        });
    });

// GESTIÓN DE LOS FORMULARIOS DE ELIMINAR DEL CARRITO
document.querySelectorAll('.form-remove-carrito')

    .forEach(form => {

        form.addEventListener('submit', async e => {

            e.preventDefault();


            const datos = new FormData(form);

            try {

                const response = await fetch(form.action, {

                    method: 'POST',

                    body: datos,

                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.loginRequired) {

                    window.location.href = '/proyecto_TFG/TFG_BackAndFront/public/login';

                    return;
                }

                mostrarToast(
                    data.message,
                    data.success ? 'success' : 'danger'
                );

                if (data.success) {

                    const producto =
                        document.getElementById(
                            `producto-${data.prendaId}`
                        );

                    if (producto) {
                        producto.remove();
                        location.reload();
                    }

                    const contador =
                        document.getElementById(
                            'contador-carrito'
                        );

                    if (contador) {
                        contador.textContent =
                            data.totalItems;
                    }

                    const contadorPagina =
                        document.getElementById(
                            'contador-productos-carrito'
                        );

                    if (contadorPagina) {
                        contadorPagina.textContent =
                            `${data.totalItems} producto(s)`;
                    }

                    if (data.total !== undefined) {

                        const subtotal =
                            document.getElementById(
                                'subtotal-carrito'
                            );

                        const total =
                            document.getElementById(
                                'total-carrito'
                            );

                        const importe =
                            Number(data.total)
                                .toFixed(2)
                                .replace('.', ',');

                        if (subtotal) {
                            subtotal.textContent =
                                `${importe} €`;
                        }

                        if (total) {
                            total.textContent =
                                `${importe} €`;
                        }
                    }
                }

            } catch (error) {

                console.error(error);

                mostrarToast(
                    'Error inesperado',
                    'danger'
                );
            }
        });
    });

// GESTIÓN DE LA COMPRA DEL CARRITO

document.querySelectorAll('.form-comprar-carrito')

    .forEach(form => {

        form.addEventListener('submit', async e => {

            console.log('submit comprar');

            e.preventDefault();

            try {

                const response = await fetch(form.action, {

                    method: 'POST',

                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.loginRequired) {

                    window.location.href = '/proyecto_TFG/TFG_BackAndFront/public/login';

                    return;
                }

                mostrarToast(
                    data.message,
                    data.success ? 'success' : 'danger'
                );

                if (data.success) {

                    document.querySelectorAll('.carrito-item')
                        .forEach(item => item.remove());

                    const contador =
                        document.getElementById('contador-carrito');

                    if (contador) {
                        contador.textContent = '0';
                    }

                    const contadorPagina =
                        document.getElementById('contador-productos-carrito');

                    if (contadorPagina) {
                        contadorPagina.textContent = '0 producto(s)';
                    }

                    const subtotal =
                        document.getElementById('subtotal-carrito');

                    const total =
                        document.getElementById('total-carrito');

                    if (subtotal) {
                        subtotal.textContent = '0,00 €';
                    }

                    if (total) {
                        total.textContent = '0,00 €';
                    }
                }
            } catch (error) {

                console.error(error);

                mostrarToast(
                    'Error inesperado',
                    'danger'
                );
            }
        });
    });