// mapModal.js
document.addEventListener('DOMContentLoaded', function() {
    const apiKey = 'AIzaSyCgXSEgnOeCKaE80Zc6ouGxxcHK61vZAR8';
    let map;
    let marker;

    // Función para inicializar el modal y el mapa
    function initMapModal() {
        // Crear elementos del modal
        const modalHTML = `
            <div id="mapModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ubicación del Domicilio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="map" style="height: 500px; width: 100%;"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Añadir el modal al body si no existe
        if (!document.getElementById('mapModal')) {
            document.body.insertAdjacentHTML('beforeend', modalHTML);
        }

        // Cargar la API de Google Maps dinámicamente
        if (!window.google) {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places`;
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
            
            script.onload = () => {
                console.log('Google Maps API cargada');
            };
        }
    }

    // Función para mostrar el mapa con la dirección
    function showMapWithAddress(addressData) {
        if (!window.google || !window.google.maps) {
            console.error('Google Maps API no está cargada');
            return;
        }

        // Inicializar el modal si no está inicializado
        initMapModal();

        // Mostrar el modal
        $('#mapModal').modal('show');

        // Esperar a que el modal se muestre completamente antes de inicializar el mapa
        $('#mapModal').on('shown.bs.modal', function() {
            const mapElement = document.getElementById('map');
            
            // Crear un geocoder para convertir la dirección en coordenadas
            const geocoder = new google.maps.Geocoder();
            
            // Construir la dirección completa
            const fullAddress = `${addressData.calle} ${addressData.numero_exterior}, ${addressData.colonia}, ${addressData.municipio}, ${addressData.estado}, ${addressData.codigo_postal}`;
            
            geocoder.geocode({ 'address': fullAddress }, function(results, status) {
                if (status === 'OK') {
                    // Obtener las coordenadas
                    const location = results[0].geometry.location;
                    
                    // Crear el mapa si no existe
                    if (!map) {
                        map = new google.maps.Map(mapElement, {
                            zoom: 16,
                            center: location,
                            mapTypeId: 'roadmap'
                        });
                    } else {
                        map.setCenter(location);
                    }
                    
                    // Eliminar el marcador anterior si existe
                    if (marker) {
                        marker.setMap(null);
                    }
                    
                    // Crear un nuevo marcador
                    marker = new google.maps.Marker({
                        map: map,
                        position: location,
                        title: fullAddress
                    });
                    
                    // Añadir ventana de información
                    const infowindow = new google.maps.InfoWindow({
                        content: `<strong>Dirección:</strong> ${fullAddress}`
                    });
                    
                    marker.addListener('click', function() {
                        infowindow.open(map, marker);
                    });
                    
                    // Abrir la ventana de información automáticamente
                    infowindow.open(map, marker);
                } else {
                    console.error('Geocode no tuvo éxito por la siguiente razón: ' + status);
                    alert('No se pudo encontrar la ubicación en el mapa. Por favor verifica la dirección.');
                }
            });
        });
    }

    // Función para extraer los datos del formulario
    function getAddressDataFromForm() {
        return {
            calle: document.getElementById('calle').value,
            numero_exterior: document.getElementById('numero_exterior').value,
            numero_interior: document.getElementById('numero_interior').value,
            colonia: document.getElementById('colonia').options[document.getElementById('colonia').selectedIndex].text,
            municipio: document.getElementById('municipio').value,
            estado: document.getElementById('estado').value,
            codigo_postal: document.getElementById('codigo_postal').value,
            entre_calle_1: document.getElementById('entre_calle_1').value,
            entre_calle_2: document.getElementById('entre_calle_2').value
        };
    }

    // Evento para mostrar el mapa cuando se complete el formulario
    document.addEventListener('addressFormCompleted', function() {
        const addressData = getAddressDataFromForm();
        showMapWithAddress(addressData);
    });

    // Inicializar el modal al cargar la página
    initMapModal();
});