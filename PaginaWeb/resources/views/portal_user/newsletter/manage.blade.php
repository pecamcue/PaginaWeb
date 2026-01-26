@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4">Gestión de <span class="text-primary">Newsletter</span></h2>

                <!-- Mostrar mensajes de sesión con SweetAlert2 -->
                @if (session('status') || session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            @if (session('status'))
                                Swal.fire({
                                    title: 'Éxito',
                                    text: '{{ session('status') }}',
                                    icon: 'success',
                                    timer: 3000,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'swal2-custom'
                                    }
                                });
                            @endif
                            @if (session('error'))
                                Swal.fire({
                                    title: 'Error',
                                    text: '{{ session('error') }}',
                                    icon: 'error',
                                    confirmButtonColor: '#d33',
                                    customClass: {
                                        popup: 'swal2-custom swal2-custom-error'
                                    }
                                });
                            @endif
                        });
                    </script>
                @endif

                <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                    @if ($subscription)
                        <span class="newsletter-status"><span class="text-success me-1">✅</span> Estás suscrito al boletín con el correo: <strong>{{ auth()->user()->email }}</strong></span>
                        <a href="{{ route('unsubscribe', ['email' => auth()->user()->email, 'token' => $subscription->unsubscribe_token]) }}?from_menu=1"
                           class="btn btn-outline-danger btn-sm rounded-pill px-3">Darse de baja</a>
                    @else
                        <span class="newsletter-status"><span class="text-warning me-1">❗</span> No estás suscrito al boletín con el correo: <strong>{{ auth()->user()->email }}</strong></span>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                            <input type="hidden" name="accept_terms" value="1">
                            <input type="hidden" name="from_menu" value="1">
                            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">Suscribirse</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <style>
        .text-primary {
            color: #2CA1B5 !important;
        }
        .btn-primary {
            background-color: #2CA1B5;
            border-color: #2CA1B5;
        }
        .btn-primary:hover {
            background-color: #1e8291;
            border-color: #1e8291;
        }
        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
        .swal2-custom {
            background-color: #ffffff !important;
            border-radius: 8px !important;
            max-width: 300px !important;
            width: 100% !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5) !important;
            color: #155724 !important;
            border: 1px solid #c3e6cb !important;
        }
        .swal2-custom-error {
            color: #721c24 !important;
            border: 1px solid #f5c6cb !important;
        }

        /* Ajustes responsive para pantallas menores a 768px (vertical, ~11 pulgadas) */
        @media (max-width: 768px) {
            h2 {
                font-size: 1.5rem;
            }
            .btn-primary,
            .btn-outline-danger {
                font-size: 0.85rem;
                padding: 6px 12px;
                width: auto;
                max-width: 200px;
                display: block;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 10px;
                text-align: center;
            }
            .newsletter-status {
                text-align: center;
                width: 100%;
                font-size: 1rem;
            }
            .d-flex.align-items-center.justify-content-center.gap-3.flex-wrap {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endsection