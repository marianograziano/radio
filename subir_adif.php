<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivoAdif'])) {
    $directorioSubidas = "uploads/"; // Asegúrate de que este directorio existe y es escribible
    $archivoSubido = $directorioSubidas . basename($_FILES['archivoAdif']['name']);

    if (move_uploaded_file($_FILES['archivoAdif']['tmp_name'], $archivoSubido)) {
        echo "El archivo ha sido subido exitosamente.";
    } else {
        echo "Hubo un error subiendo el archivo.";
    }
} else {
    echo "No se recibió ningún archivo.";
}
?>
