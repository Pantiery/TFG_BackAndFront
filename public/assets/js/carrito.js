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