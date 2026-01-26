<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago cancelado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .swal2-popup {
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
            padding: 1.5rem !important;
        }
        .swal2-title {
            color: #dc3545 !important;
            font-weight: 600 !important;
            font-size: 1.6rem !important;
        }
        .swal2-html-container {
            color: #555 !important;
            font-size: 1rem !important;
            margin: 1rem 0 !important;
        }
        .swal2-confirm {
            background-color: #dc3545 !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.5rem !important;
            font-weight: 500 !important;
            font-size: 1rem !important;
            transition: all 0.2s ease !important;
        }
        .swal2-confirm:hover {
            background-color: #c82333 !important;
            transform: translateY(-1px) !important;
        }
        .swal2-timer-progress-bar {
            background-color: #dc3545 !important;
            height: 6px !important;
            border-radius: 3px !important;
        }
        .swal2-icon.swal2-error {
            border-color: #dc3545 !important;
        }
        .swal2-icon.swal2-error .swal2-x-mark {
            color: #dc3545 !important;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="spinner-border text-danger" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const redirectUrl = '{{ $redirectUrl ?? "http://localhost:4200/carrito" }}';
            const orderId = '{{ $order_id ?? "desconocido" }}';
            const message = `{!! addslashes($message ?? 'Comprueba que tus datos sean correctos y vuelve a intentar.') !!}`;

            Swal.fire({
                icon: 'error',
                title: 'Pago cancelado',
                html: `
                    <p style="margin: 0.5rem 0; font-size: 1.1rem;">
                        Tu pedido <strong>#${orderId}</strong> no se ha completado.
                    </p>
                    <p style="color: #666; font-size: 0.95rem; margin-top: 0.5rem;">
                        ${message}
                    </p>
                `,
                confirmButtonText: 'Volver al carrito',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: true,
                timer: 6000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal2-popup',
                    title: 'swal2-title',
                    htmlContainer: 'swal2-html-container',
                    confirmButton: 'swal2-confirm'
                },
                buttonsStyling: false,
                didOpen: () => {
                    const confirmBtn = Swal.getConfirmButton();
                    confirmBtn.style.boxShadow = '0 4px 12px rgba(220, 53, 69, 0.3)';
                }
            }).then((result) => {
                if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                    window.location.href = redirectUrl;
                }
            });

            // Redirección automática por si falla SweetAlert
            setTimeout(() => {
                if (Swal.isVisible()) Swal.close();
                window.location.href = redirectUrl;
            }, 6500);
        });
    </script>
</body>
</html>