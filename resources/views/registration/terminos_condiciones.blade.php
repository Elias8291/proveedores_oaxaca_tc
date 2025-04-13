@extends('dashboard')

@section('title', 'Inscripción al Padrón de Proveedores - Proveedores de Oaxaca')
<link rel="stylesheet" href="{{ asset('assets/css/registration.css') }}">

@section('content')
<div class="dashboard-container">
    <div class="registration-section">
        <h1>Inscripción al Padrón de Proveedores</h1>
        <p>Antes de continuar con tu registro en el padrón de proveedores de Oaxaca, por favor revisa y acepta los siguientes términos y condiciones:</p>
        <p>Tipo de solicitante: <strong>{{ Auth::user()->solicitante->tipo_persona }}</strong>. Recibirás formularios según este tipo.</p>
        <div class="terms-section">
            <h3>Términos y Condiciones</h3>
            <p>Al avanzar con tu inscripción, aceptas lo siguiente:</p>
            <p>
                - Proporcionarás información completa, veraz y actualizada en los pasos siguientes de este proceso.<br>
                - Los datos que compartas, como el nombre de tu empresa, correo electrónico y teléfono, serán utilizados exclusivamente para gestionar tu registro y participación en el padrón de proveedores.<br>
                - Cumplirás con las normativas locales y estatales de Oaxaca aplicables a los proveedores registrados.<br>
                - Permitirás la verificación de tu información por parte del equipo de Proveedores de Oaxaca para garantizar la integridad del padrón.<br>
                - Nos comprometemos a proteger tus datos conforme a las leyes de privacidad vigentes, usándolos solo para los fines establecidos en este proceso.<br>
                - Podrás actualizar tu información en cualquier momento si hay cambios significativos.
            </p>
            <p>Al aceptar estos términos, podrás continuar con el registro y formar parte de nuestra red de proveedores en Oaxaca.</p>
        </div>
        <form action="{{ route('registration.form1') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">He leído y acepto los términos y condiciones</label>
            </div>
            <button type="submit" class="btn-submit">Continuar con el Registro</button>
        </form>
    </div>
</div>
<script>
document.getElementById('termsForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!document.getElementById('terms').checked) {
        alert('Debes aceptar los términos y condiciones');
        return;
    }

    // Enviar el formulario mediante AJAX
    fetch(this.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({terms: true})
    })
    .then(response => response.json())
    .then(data => {
        if (data.numero_seccion === 1) {
            // Redirigir al siguiente paso del formulario
            window.location.href = "{{ route('registration.form1') }}";
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al procesar tu solicitud');
    });
});
</script>
@endsection