<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Reserva</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden;">

                <!-- Header -->
                <tr>
                    <td style="background-color: #4F46E5; padding: 30px; text-align: center;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 28px;">
                            🍽️ Reserva Criada!
                        </h1>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding: 40px 30px;">
                        <p style="font-size: 16px; color: #333333; margin: 0 0 20px 0;">
                            Olá <strong>{{ $name }}</strong>,
                        </p>

                        <p style="font-size: 16px; color: #333333; margin: 0 0 30px 0;">
                            Sua reserva foi criada com sucesso!
                        </p>

                        <!-- Info Box -->
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-left: 4px solid #4F46E5; border-radius: 4px; margin-bottom: 30px;">
                            <tr>
                                <td style="padding: 20px;">
                                    <p style="margin: 0 0 10px 0; font-size: 14px; color: #6b7280;">
                                        <strong style="color: #111827;">📅 Data:</strong> {{ $date }}
                                    </p>
                                    <p style="margin: 0 0 10px 0; font-size: 14px; color: #6b7280;">
                                        <strong style="color: #111827;">⏰ Horário:</strong> {{ $initHour }} - {{ $endHour }}
                                    </p>
                                    <p style="margin: 0 0 10px 0; font-size: 14px; color: #6b7280;">
                                        <strong style="color: #111827;">🍽️ Restaurante:</strong> {{ $restaurant }}
                                    </p>
                                    <p style="margin: 0 0 10px 0; font-size: 14px; color: #6b7280;">
                                        <strong style="color: #111827;">🪑 Mesa:</strong> {{ $table }}
                                    </p>
                                    <p style="margin: 0; font-size: 14px; color: #6b7280;">
                                        <strong style="color: #111827;">👥 Pessoas:</strong> {{ $guests }}
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <!-- Warning Box -->
                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 4px; margin-bottom: 30px;">
                            <tr>
                                <td style="padding: 15px;">
                                    <p style="margin: 0; font-size: 14px; color: #92400e;">
                                        <strong>⏰ Atenção:</strong> Confirme sua reserva em até <strong>30 minutos</strong> ou ela será cancelada automaticamente.
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <p style="font-size: 16px; color: #333333; margin: 0 0 20px 0;">
                            Por favor, confirme sua reserva clicando no botão abaixo:
                        </p>

                        <!-- Buttons -->
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
                            <tr>
                                <td align="center" style="padding: 20px 0;">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="padding: 0 10px;">
                                                <a href="{{ $confirmUrl }}" style="display: inline-block; padding: 15px 40px; background-color: #10b981; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px;">
                                                    ✅ Confirmar
                                                </a>
                                            </td>
                                            <td style="padding: 0 10px;">
                                                <a href="{{ $cancelUrl }}" style="display: inline-block; padding: 15px 40px; background-color: #ef4444; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px;">
                                                    ❌ Cancelar
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                        <p style="margin: 0 0 5px 0; font-size: 12px; color: #6b7280;">
                            Este é um email automático, não responda.
                        </p>
                        <p style="margin: 0; font-size: 12px; color: #6b7280;">
                            {{ config('app.name') }} &copy; {{ date('Y') }}
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
