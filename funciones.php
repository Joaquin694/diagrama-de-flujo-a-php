<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['ingresar'])) {

        $valor = $_POST['ingresar'];
        $funcion = $_POST['funcion'];

    

    $archivo_php = fopen("codigo.php", "a") or die("No se pudo abrir el archivo.");
    $archivo_json = "datos.json";

    switch ($funcion) {

        case 'empty-f':
            fwrite($archivo_php, "echo empty('$valor');\n");
            break;

        case 'unset-f':
            fwrite($archivo_php, "unset('$valor');\n");
            break;

        case 'isset-f':
            fwrite($archivo_php, "echo isset('$valor');\n");
            break;

        case 'count-f':
            fwrite($archivo_php, "echo count('$valor');\n");
            break;

        case 'print_r-f':
            fwrite($archivo_php, "print_r('$valor');\n");
            break;

        case 'echo-f':
            fwrite($archivo_php, "echo('$valor');\n");
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
            'valor' => $valor
        ];

        file_put_contents($archivo_json, json_encode($data));


        header("Location: index.php");
        exit;

    }


}


?>
