// GESTIÓN DE LOS FORMULARIOS DE PAGO DE VENTAS

document.querySelectorAll('.form-pagar-venta')

    .forEach(form => {

        form.addEventListener('submit', async e => {
            console.log('submit pago');
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

                mostrarToast(
                    data.message,
                    data.success ? 'success' : 'danger'
                );

                if (data.success) {

                    form.outerHTML = `
                    <span class="text-success fw-bold">
                    ✔ Pagada
                    </span>`;
                }

                const estado = document.getElementById(
                    `estado-venta-${data.ventaId}`
                );

                if (estado) {

                    estado.innerHTML = `
                    <span class="badge bg-success px-3 py-2">
                        Pagado
                    </span>`;
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