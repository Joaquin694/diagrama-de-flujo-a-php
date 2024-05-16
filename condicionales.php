<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['condicion-1'])) {

        $condicion1 = $_POST['condicion-1'];
        $condicion2 = $_POST['condicion-2'];
	$respuesta = $_POST['respuesta'];
        $funcion = $_POST['funcion-c'];

    

    $archivo_php = fopen("codigo.php", "a") or die("No se pudo abrir el archivo.");
    $archivo_json = "datos.json";

    switch ($funcion) {

        case 'if-f':
            fwrite($archivo_php, "if ($condicion1 > $condicion2) { echo $respuesta; }\n");
            break;
        default:
            fwrite($archivo_php, "Error: Funciones.php -> switchFunction;\n");
            break;

        }

        fclose($archivo_php);

 
        $data = [];
        
        if (file_exists($archivo_json)) {
            $data = json_decode(file_get_contents($archivo_json), true);
        }


        $data[$funcion] = [
            'funcion' => $funcion
        ];

        file_put_contents($archivo_json, json_encode($data));


        header("Location: index.php");
        exit;

    }


}


?>
