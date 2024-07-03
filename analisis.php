<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el JSON enviado desde el cliente
    $json = isset($_POST['json']) ? $_POST['json'] : '';
    
    if (!$json) {
        die('No se recibió JSON válido.');
    }

    // Decodifica el JSON a un array PHP
    $data = json_decode($json, true);

    if (!$data) {
        die('Error al decodificar JSON.');
    }

    // Ruta del archivo tucodigo.php
    $filePath = 'tucodigo.php';

    // Abre el archivo tucodigo.php para escritura
    $file = fopen($filePath, 'w');
    
    if (!$file) {
        die('Error al abrir el archivo tucodigo.php para escritura.');
    }

    // Intenta escribir la cabecera del archivo PHP
    if (fwrite($file, "<?php\n") === false) {
        die('Error al escribir la cabecera del archivo PHP.');
    }

    // Crea un array para almacenar los textos de los nodos
    $textByKey = [];
    foreach ($data['nodeDataArray'] as $node) {
        if (isset($node['text']) && $node['text']) {
            // Guardamos el texto del nodo con su clave
            $textByKey[$node['key']] = $node['text'];
        }
    }

    // Recorre el array de enlaces para generar el código PHP
    foreach ($data['linkDataArray'] as $link) {
        $fromKey = $link['from'];
        $toKey = $link['to'];

        // Verifica si el nodo de origen tiene el texto 'Escribir'
        if (isset($textByKey[$fromKey]) && $textByKey[$fromKey] === 'Escribir') {
            // Encuentra el texto del nodo destino
            $toText = $textByKey[$toKey] ?? '';

            // Genera el código PHP solo si tenemos un texto de destino
            if ($toText) {
                if (fwrite($file, "echo \"{$toText}\";\n") === false) {
                    die('Error al escribir el código de salida (echo).');
                }
            }
        }

        // Verifica si el nodo de origen tiene el texto 'Asignar'
        if (isset($textByKey[$fromKey]) && $textByKey[$fromKey] === 'Asignar') {
            // Encuentra el valor del nodo de destino
            $valueText = $textByKey[$toKey] ?? '';

            // Encuentra el nodo hijo de 'Asignar' para obtener el nombre de la variable
            $variableNode = array_filter($data['linkDataArray'], function($link) use ($toKey) {
                return $link['from'] === $toKey;
            });

            // Extrae el texto del nodo de destino
            $variableText = '';
            foreach ($variableNode as $link) {
                $variableText = $textByKey[$link['to']] ?? '';
                break; // Solo necesitamos el primer nodo que hereda del nodo 'Asignar'
            }

            // Genera el código PHP solo si tenemos un texto de variable y un valor
            if ($variableText && $valueText) {
                // Reemplaza las expresiones matemáticas simples en el valor
                $valueText = preg_replace('/(\w+)/', '$$1', $valueText);
                if (fwrite($file, "{$valueText} = {$variableText};\n") === false) {
                    die('Error al escribir el código de asignación.');
                }
            }
        }
    }

    // Intenta escribir el pie del archivo PHP
    if (fwrite($file, "?>\n") === false) {
        die('Error al escribir el pie del archivo PHP.');
    }

    // Cierra el archivo
    fclose($file);

    // Ahora descargamos el archivo tucodigo.php
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="tucodigo.php"');
    readfile($filePath);
    exit;
}
?>

