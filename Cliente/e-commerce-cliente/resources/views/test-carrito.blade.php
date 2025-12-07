<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <h1>Prueba de Carrito</h1>

    <form id="test-form">
        @csrf
        <input type="hidden" name="producto_id" value="1">
        <input type="hidden" name="nombre" value="Producto Test">
        <input type="hidden" name="precio" value="100">
        <input type="hidden" name="imagen" value="test.jpg">
        <input type="number" name="cantidad" value="1" min="1">

        <button type="button" onclick="testAgregar()">Agregar al Carrito</button>
    </form>

    <div id="result"></div>

    <script>
        async function testAgregar() {
            const form = document.getElementById('test-form');
            const formData = new FormData(form);

            console.log('Enviando datos:', Object.fromEntries(formData.entries()));

            try {
                const response = await fetch('/carrito/agregar', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });

                const data = await response.json();
                console.log('Respuesta:', data);

                document.getElementById('result').innerHTML =
                    `<pre>${JSON.stringify(data, null, 2)}</pre>`;

                // Probar obtener contador
                const contadorResponse = await fetch('/carrito/contador');
                const contadorData = await contadorResponse.json();
                console.log('Contador:', contadorData);

            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Probar obtener contador al cargar
        fetch('/carrito/contador')
            .then(r => r.json())
            .then(data => console.log('Contador inicial:', data));
    </script>
</body>

</html>
