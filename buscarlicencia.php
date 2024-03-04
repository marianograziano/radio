<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda de Licencias !</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $(document).ready(function() {
        $("#senal_distintiva").autocomplete({
            source: "search.php",
            select: function(event, ui) {
                $.ajax({
                    url: 'fetch.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {senal_distintiva: ui.item.value},
                    success: function(data) {
                        $("#resultados").html(`<p>Titular: ${data.titular}</p><p>Señal Distintiva: ${data.senal_distintiva}</p><p>Categoría: ${data.categoria}</p><p>Expiración: ${data.expiracion}</p><p>Provincia: ${data.provincia}</p><p>Localidad: ${data.localidad}</p>`);
                    }
                });
            }
        });
    });
    </script>
</head>
<body>
    <label for="senal_distintiva">Buscar Señal Distintiva: !</label>
    <input id="senal_distintiva" type="text">
    <div id="resultados"></div>
</body>
</html>
