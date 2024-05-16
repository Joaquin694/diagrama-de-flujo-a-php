<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['nombre']) && isset($_POST['tipo']) ) {

        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        $dato = $_POST['dato'];
        $variable1 = $_POST['variable1'];
        $variable2 = $_POST['variable2'];

        $archivo_php = fopen("codigo.php", "a") or die("No se pudo abrir el archivo.");
        $archivo_json = "datos.json";


        if ($tipo === "constante") {

            fwrite($archivo_php, "\ndefine('$nombre', '$dato');\n");

        } elseif ($tipo === "suma") {
            
            fwrite($archivo_php, "\n\$$nombre = \$$variable2 + \$$variable1;\n");

        } elseif ($tipo === "array") {

            $array_valor = explode(",", $dato);
            
            $array_valor = array_map(function($val) { return "'$val'"; }, $array_valor);

            $array_string = implode(", ", $array_valor);

            fwrite($archivo_php, "\n\$$nombre = array($array_string);\n");

        } else {
            fwrite($archivo_php, "\n$$nombre = ");

            switch ($tipo) {
                case 'texto':
                    fwrite($archivo_php, "'$dato';\n");
                    break;
                case 'numero':
                    fwrite($archivo_php, "$dato;\n");
                    break;
                case 'booleano':
                    fwrite($archivo_php, ($dato === 'true' ? 'true' : 'false') . ";\n");
                    break;
                default:

                    fwrite($archivo_php, "'$dato';\n");
                    break;
            }
        }


        fclose($archivo_php);

 
        $data = [];
        if (file_exists($archivo_json)) {
            $data = json_decode(file_get_contents($archivo_json), true);
        }


        $data[$nombre] = [
            'tipo' => $tipo,
            'valor' => $dato
        ];

        file_put_contents($archivo_json, json_encode($data));


        header("Location: index.php");
        exit;
    }
}
?>
