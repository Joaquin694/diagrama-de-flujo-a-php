<?php
// Recibimos los datos enviados por POST desde JavaScript
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Manejamos los datos de variable
    if (isset($_POST['variableName']) && isset($_POST['variableData'])) {
        $variableName = $_POST['variableName'];
        $variableData = $_POST['variableData'];
        $phpVariableCode = "\$" . $variableName . " = " . $variableData . ";";
        file_put_contents('codigo.php', $phpVariableCode . PHP_EOL, FILE_APPEND);
    }

    // Manejamos los datos de array
    if (isset($_POST['arrayName']) && isset($_POST['arrayData'])) {
        $arrayName = $_POST['arrayName'];
        $arrayData = $_POST['arrayData'];
        // Convertimos los datos del array en un arreglo PHP
        $dataArray = explode(",", $arrayData);
        $phpArrayCode = "\$" . $arrayName . " = [" . implode(", ", $dataArray) . "];";
        file_put_contents('codigo.php', $phpArrayCode . PHP_EOL, FILE_APPEND);
    }
}
?>

