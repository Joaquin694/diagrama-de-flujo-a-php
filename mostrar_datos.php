<?php
// Cargar los datos del archivo JSON
$data = file_get_contents('datos.json');
$datos = json_decode($data, true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Almacenados</title>
</head>
<body>
    <h1>Datos Almacenados</h1>

    <?php if (!empty($datos)) : ?>
        <ul>
            <?php foreach ($datos as $nombre => $info) : ?>
                <li><?php echo $nombre . ': ' . json_encode($info); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No hay datos almacenados.</p>
    <?php endif; ?>
</body>
</html>
