@component('mail::message')

    # Reserva criada!

    Olá {{ $name }} sua reserva foi criada com sucesso!

    Informações da reserva:
    Data: {{ $date }}
    Hora: {{ $hour }}
    Restaurante: {{ $restaurant }}

    Por favor, confirme sua reserva clicando no botão abaixo:

    @component('mail::button', ['url' => $url])
        Confirmar
    @endcomponent

    Obs: Em 30 minutos sem confirmação sua reserva será cancelada automaticamente.
@endcomponent
