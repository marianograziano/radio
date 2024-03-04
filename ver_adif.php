<?php
function parsearADIF($archivo) {
    $contactos = [];
    $contenido = file_get_contents($archivo);
    $contenido = strtoupper($contenido); // Normaliza el contenido a mayúsculas
    $registros = preg_split('/<EOR>|<EOH>/', $contenido);
    foreach ($registros as $registro) {
        if (trim($registro)) {
            preg_match_all('/<(.+?):(\d+).*?>([^<]+)/', $registro, $matches, PREG_SET_ORDER);
            $contacto = [];
            foreach ($matches as $match) {
                $campo = strtoupper($match[1]);
                $valor = $match[3];
                if (!in_array($campo, ['PROGRAMID', 'PROGRAMVERSION', 'ADIF_VER', 'CREATED_TIMESTAMP'])) {
                    $contacto[$campo] = $valor;
                }
            }
            if (!empty($contacto)) {
                $contactos[] = $contacto;
            }
        }
    }
    return $contactos;
}

// Usa glob() para listar todos los archivos .adi en la carpeta uploads/
$archivos = glob('uploads/*.adi');

echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar ADIF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Información de Contactos ADIF</h2>';

foreach ($archivos as $archivo) {
    $contactos = parsearADIF($archivo);
    // Extrae solo el nombre del archivo para mostrarlo
    $nombreArchivo = basename($archivo);
    echo "<h3>Archivo: $nombreArchivo</h3>";
    if (!empty($contactos)) {
        echo '<table class="table">
                <thead>
                    <tr>';
        // Asume que todos los registros tienen un conjunto similar de campos
        foreach (array_keys($contactos[0]) as $campo) {
            echo "<th>$campo</th>";
        }
        echo '</tr>
                </thead>
                <tbody>';
        foreach ($contactos as $contacto) {
            echo '<tr>';
            foreach ($contacto as $valor) {
                echo "<td>$valor</td>";
            }
            echo '</tr>';
        }
        echo '</tbody>
            </table>';
    } else {
        echo "<p>No se encontraron contactos en el archivo.</p>";
    }
}
echo '</div>
</body>
</html>';
?>
