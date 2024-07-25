<?php
session_start(); // Inicia la sesión
include 'ConexionBD.php'; // Incluye el archivo para la conexión a la base de datos
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Establece la codificación de caracteres a UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configuración de la vista para dispositivos móviles -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Enlace a la fuente externa de Google Fonts -->
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS externo -->
    <title>Agencia de Viajes</title>
    
                
    </head>
<body>
    <header>
        <h1>Bienvenidos a Agencia de Viajes WWW</h1> <!-- Título de la página -->
    </div>
    </header>

    </header>

    <nav>
        <ul>
         <li><a href="administracion.php">Administración</a></li> <!-- Nueva página de administración -->
        </ul>
    </nav>
    <br>
   <!-- Incluir notificaciones desde un archivo externo -->

    <div id="notifications-container">
        <!-- Contenedor de notificaciones en tiempo real -->
    </div>
    

    <div class="filter-form">
        <h2>Buscar Destino</h2>
        <label>Origen:</label>
        <input type="text" id="Origen" placeholder="Origen" value="Santiago"> <!-- Campo de entrada para el origen del viaje -->
        <form id="searchForm" method="POST"> <!-- Formulario de búsqueda -->
            <label for="tipo_servicio">Tipo de Servicio:</label>
            <select id="tipo_servicio" name="tipo_servicio"> <!-- Desplegable para seleccionar el tipo de servicio -->
                <option value="">Seleccione un servicio</option>
                <?php
                    $consulta = "SELECT DISTINCT tipo_servicio FROM simulaciones"; // Consulta para obtener tipos de servicio únicos
                    $ejecutar = mysqli_query($conexionBD, $consulta) or die(mysqli_error($conexionBD));
                    while ($opciones = mysqli_fetch_assoc($ejecutar)) { // Llenar el desplegable con los resultados de la consulta
                        echo "<option value=\"{$opciones['tipo_servicio']}\">{$opciones['tipo_servicio']}</option>";
                    }
                ?>
            </select>

            <label for="nombre_hotel">Nombre del Hotel:</label>
            <select id="nombre_hotel" name="nombre_hotel"> <!-- Desplegable para seleccionar el nombre del hotel -->
                <option value="">Seleccione un hotel</option>
                <?php
                    $consulta = "SELECT DISTINCT nombre_hotel FROM simulaciones"; // Consulta para obtener nombres de hotel únicos
                    $ejecutar = mysqli_query($conexionBD, $consulta) or die(mysqli_error($conexionBD));
                    while ($opciones = mysqli_fetch_assoc($ejecutar)) { // Llenar el desplegable con los resultados de la consulta
                        echo "<option value=\"{$opciones['nombre_hotel']}\">{$opciones['nombre_hotel']}</option>";
                    }
                ?>
            </select>

            <label for="ciudad">Ciudad:</label>
            <select id="ciudad" name="ciudad"> <!-- Desplegable para seleccionar la ciudad -->
                <option value="">Seleccione una ciudad</option>
                <?php
                    $consulta = "SELECT DISTINCT ciudad FROM simulaciones"; // Consulta para obtener ciudades únicas
                    $ejecutar = mysqli_query($conexionBD, $consulta) or die(mysqli_error($conexionBD));
                    while ($opciones = mysqli_fetch_assoc($ejecutar)) { // Llenar el desplegable con los resultados de la consulta
                        echo "<option value=\"{$opciones['ciudad']}\">{$opciones['ciudad']}</option>";
                    }
                ?>
            </select>

            <label for="pais">País:</label>
            <select id="pais" name="pais"> <!-- Desplegable para seleccionar el país -->
                <option value="">Seleccione un país</option>
                <?php
                    $consulta = "SELECT DISTINCT pais FROM simulaciones"; // Consulta para obtener países únicos
                    $ejecutar = mysqli_query($conexionBD, $consulta) or die(mysqli_error($conexionBD));
                    while ($opciones = mysqli_fetch_assoc($ejecutar)) { // Llenar el desplegable con los resultados de la consulta
                        echo "<option value=\"{$opciones['pais']}\">{$opciones['pais']}</option>";
                    }
                ?>
            </select>
            <br>
            <label for="fecha_viaje">Fecha de Viaje:</label>
            <input type="date" id="fecha_viaje" name="fecha_viaje"> <!-- Campo de entrada para la fecha del viaje -->

            <label for="duracion_viaje">Duración del Viaje (días):</label>
            <input type="number" id="duracion_viaje" name="duracion_viaje" min="1"> <!-- Campo de entrada para la duración del viaje -->

            <button type="submit">Buscar</button> <!-- Botón para enviar el formulario -->
            <button type="button" id="limpiarBtn">Limpiar</button> <!-- Botón para limpiar el formulario -->
        </form>
    </div>

    <div id="results-container">
        <!-- Contenedor de resultados de búsqueda -->
    </div>

    <div class="cart-icon" onclick="mostrarCarrito()">
        <span id="carrito-icono">0</span>
    </div>

    <div class="cart" id="cart-container">
    <h2>Carrito de Compras</h2>
    <ul id="carrito"></ul>
    <p>Total: $<span id="total">0</span></p>
    <button class="checkout-btn" onclick="finalizarCompra()">Finalizar compra</button>
</div>          
            
    <footer>
        <p>&copy; 2024 Agencia de Viajes</p> <!-- Pie de página -->
    </footer>

    <!-- ******nuevo******* -->

    <script>
        
        let carrito = JSON.parse(localStorage.getItem('carrito')) || []; // Carga el carrito desde el almacenamiento local o inicializa un carrito vacío
        let total = carrito.reduce((acc, item) => acc + item.precio * item.cantidad, 0); // Calcula el total inicial sumando los precios y cantidades de los artículos en el carrito
        actualizarCarrito(); // Actualiza la visualización del carrito
        actualizarIconoCarrito(); // Actualiza el icono del carrito con el número de artículos

        document.getElementById('limpiarBtn').addEventListener('click', function() {
            document.getElementById('searchForm').reset(); // Limpia el formulario de búsqueda
            document.getElementById('results-container').innerHTML = ''; // Limpia los resultados de búsqueda
        });

        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Previene el comportamiento por defecto del formulario

            const formData = new FormData(this); // Crea un objeto FormData con los datos del formulario

            fetch('busqueda.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('results-container').innerHTML = data; // Muestra los resultados de la búsqueda

                document.querySelectorAll('.resultado').forEach(result => {
                    const nombre = result.dataset.nombre; // Obtiene el nombre del resultado
                    const precio = parseFloat(result.dataset.precio); // Obtiene el precio del resultado
                    const button = document.createElement('button'); // Crea un botón para agregar al carrito
                    button.className = 'btn';
                    button.textContent = 'Agregar al Carrito';
                    button.onclick = () => agregarAlCarrito(nombre, precio); // Define la función de clic del botón
                    result.appendChild(button); // Añade el botón al resultado
                });
            })
            .catch(error => console.error('Error:', error)); // Muestra un error en la consola si ocurre
        });

        function agregarAlCarrito(nombre, precio) {
            let encontrado = carrito.find(item => item.nombre === nombre); // Busca el artículo en el carrito

            if (encontrado) {
                encontrado.cantidad++; // Incrementa la cantidad si el artículo ya está en el carrito
            } else {
                carrito.push({ nombre, precio, cantidad: 1 }); // Añade el artículo al carrito si no está
            }

            total += precio; // Incrementa el total
            actualizarCarrito(); // Actualiza la visualización del carrito
            actualizarIconoCarrito(); // Actualiza el icono del carrito
            guardarCarrito(); // Guarda el carrito en el almacenamiento local
        }

        function actualizarCarrito() {
            const carritoElement = document.getElementById('carrito'); // Obtiene el elemento del carrito
            const totalElement = document.getElementById('total'); // Obtiene el elemento del total

            carritoElement.innerHTML = ''; // Limpia el carrito
            carrito.forEach(item => {
                const li = document.createElement('li'); // Crea un elemento de lista para cada artículo
                li.innerHTML = `
                    <div class="cart-item">
                        <span>${item.nombre} - $${item.precio} x ${item.cantidad}</span>
                        <div class="item-actions">
                            <button class="btn btn-sm" onclick="restarCantidad('${item.nombre}', ${item.precio})">-</button>
                            <span class="quantity">${item.cantidad}</span>
                            <button class="btn btn-sm" onclick="sumarCantidad('${item.nombre}', ${item.precio})">+</button>&nbsp
                            <button class="btn btn-sm remove-btn" onclick="eliminarDelCarrito('${item.nombre}', ${item.precio}, ${item.cantidad})">Eliminar</button>
                        </div>
                    </div>
                `;
                carritoElement.appendChild(li); // Añade el artículo al carrito
            });

            totalElement.textContent = total; // Actualiza el total
        }

        function sumarCantidad(nombre, precio) {
            let encontrado = carrito.find(item => item.nombre === nombre); // Busca el artículo en el carrito
            encontrado.cantidad++; // Incrementa la cantidad
            total += precio; // Incrementa el total
            actualizarCarrito(); // Actualiza la visualización del carrito
            actualizarIconoCarrito(); // Actualiza el icono del carrito
            guardarCarrito(); // Guarda el carrito en el almacenamiento local
        }

        function restarCantidad(nombre, precio) {
            let encontrado = carrito.find(item => item.nombre === nombre); // Busca el artículo en el carrito
            if (encontrado.cantidad > 1) {
                encontrado.cantidad--; // Decrementa la cantidad si es mayor a 1
                total -= precio; // Decrementa el total
                actualizarCarrito(); // Actualiza la visualización del carrito
                actualizarIconoCarrito(); // Actualiza el icono del carrito
                guardarCarrito(); // Guarda el carrito en el almacenamiento local
            }
        }

        function eliminarDelCarrito(nombre, precio, cantidad) {
            let encontradoIndex = carrito.findIndex(item => item.nombre === nombre); // Busca el índice del artículo en el carrito
            carrito.splice(encontradoIndex, 1); // Elimina el artículo del carrito
            total -= precio * cantidad; // Decrementa el total
            actualizarCarrito(); // Actualiza la visualización del carrito
            actualizarIconoCarrito(); // Actualiza el icono del carrito
            guardarCarrito(); // Guarda el carrito en el almacenamiento local
        }

        function mostrarCarrito() {
            const cartContainer = document.getElementById('cart-container'); // Obtiene el contenedor del carrito
            if (cartContainer.style.display === 'none' || cartContainer.style.display === '') {
                cartContainer.style.display = 'block'; // Muestra el carrito si está oculto
            } else {
                cartContainer.style.display = 'none'; // Oculta el carrito si está visible
            }
        }

        function actualizarIconoCarrito() {
            const iconoCarrito = document.getElementById('carrito-icono'); // Obtiene el icono del carrito
            iconoCarrito.textContent = carrito.reduce((total, item) => total + item.cantidad, 0); // Actualiza el icono con el número total de artículos
        }

        function simularPago() {
            if (carrito.length > 0) {
                alert(`Simulando pago por un total de $${total}`); // Muestra una alerta con el total
                carrito = []; // Vacía el carrito
                total = 0; // Resetea el total
                actualizarCarrito(); // Actualiza la visualización del carrito
                actualizarIconoCarrito(); // Actualiza el icono del carrito
                localStorage.removeItem('carrito'); // Elimina el carrito del almacenamiento local
                const cartContainer = document.getElementById('cart-container'); // Obtiene el contenedor del carrito
                cartContainer.style.display = 'none'; // Oculta el carrito
            } else {
                alert('Agregue productos al carrito primero.'); // Muestra una alerta si el carrito está vacío
            }
        }

        function guardarCarrito() {
            localStorage.setItem('carrito', JSON.stringify(carrito)); // Guarda el carrito en el almacenamiento local
        }

        document.addEventListener("DOMContentLoaded", () => {
            const contenedorNotificaciones = document.getElementById("notifications-container"); // Obtiene el contenedor de notificaciones
            const ofertasEspeciales = [
                "25% de descuento en vuelos a París",
                "Paquete turístico a Cancún por USD$1.599",
                "Ofertas de último minuto a Roma"
            ];

            let indiceOferta = 0; // Inicializa el índice de la oferta

            function actualizarOferta() {
                contenedorNotificaciones.textContent = ofertasEspeciales[indiceOferta]; // Actualiza el contenido de la notificación
                indiceOferta = (indiceOferta + 1) % ofertasEspeciales.length; // Incrementa el índice y lo resetea si llega al final del array
            }

            actualizarOferta(); // Llama a la función para mostrar la primera oferta
            setInterval(actualizarOferta, 3000); // Actualiza la oferta cada 3 segundos
        });


        function finalizarCompra() {
        if (carrito.length > 0) {
            window.location.href = 'datos-personales.php';
        } else {
            alert('Agregue productos al carrito primero.');
        }
    }


    </script>
</body>
</html>
