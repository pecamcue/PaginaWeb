<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Suscripción</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Arial', sans-serif; background-color: #f4f4f4; color: #333;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #2CA1B5; padding: 20px; text-align: center;">
                            @if(isset($logoBase64) && $logoBase64)
                                <img src="{{ $logoBase64 }}" alt="Logo Concha Cuevas" style="max-width: 150px; height: auto;">
                            @else
                                <p style="color: #ffffff; font-size: 18px; font-weight: bold;">Audiología y Óptica Concha Cuevas</p>
                            @endif
                            <h1 style="color: #ffffff; margin: 10px 0; font-size: 24px;">¡Bienvenido a nuestra Newsletter!</h1>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #2CA1B5; font-size: 20px; margin-bottom: 20px;">Gracias por suscribirte, {{ $subscription->email }}!</h2>
                            <p style="font-size: 16px; line-height: 1.5; margin-bottom: 20px;">
                                Estás ahora suscrito a nuestras actualizaciones y novedades. Recibirás noticias sobre ofertas, servicios y más.
                            </p>
                            <p style="font-size: 16px; margin: 20px 0;">
                                Si deseas cancelar tu suscripción, haz clic en el siguiente botón:
                            </p>
                            <p style="text-align: center;">
                                <a href="{{ route('unsubscribe', ['email' => $subscription->email, 'token' => $subscription->unsubscribe_token]) }}" 
                                   style="display: inline-block; padding: 12px 24px; background-color: #dc3545; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px;">
                                   Cancelar suscripción
                                </a>
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 14px; color: #6c757d;">
                            <p style="margin: 0;">¡Gracias por confiar en nosotros!</p>
                            <p style="margin: 5px 0;">Av. Seminari 4, Moncada - Valencia</p>
                            <p style="margin: 0;"><a href="mailto:info@conchacuevas.es" style="color: #2CA1B5; text-decoration: none;">info@conchacuevas.es</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>