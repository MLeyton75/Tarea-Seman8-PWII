// Agrega un evento 'submit' al formulario con id 'searchForm'
document.getElementById('searchForm').addEventListener('submit', function(event) {
    // Evita que el formulario se envíe de forma predeterminada
    event.preventDefault();

    // Crea un objeto FormData con los datos del formulario
    const formData = new FormData(this);
    // Crea un objeto URLSearchParams para construir la cadena de consulta
    const params = new URLSearchParams();
    // Recorre los pares clave-valor de FormData y los agrega a URLSearchParams
    formData.forEach((value, key) => {
        params.append(key, value);
    });

    // Realiza una solicitud fetch a 'busqueda.php' con el método POST y el cuerpo de la solicitud
    fetch('busqueda.php', {
        method: 'POST',
        body: params
    })
    // Convierte la respuesta a texto
    .then(response => response.text())
    // Inserta los datos obtenidos en el elemento con id 'result'
    .then(data => {
        document.getElementById('result').innerHTML = data;
    })
    // Muestra un error en la consola en caso de que ocurra uno
    .catch(error => console.error('Error:', error));
});

// Agrega un evento 'click' al botón con id 'limpiarBtn'
document.getElementById('limpiarBtn').addEventListener('click', function() {
    // Restablece el formulario con id 'searchForm'
    document.getElementById('searchForm').reset();
    // Limpia el contenido del elemento con id 'result'
    document.getElementById('result').innerHTML = '';
});


