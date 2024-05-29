<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario PHP</title>
</head>
<body>
    <h1>Formulario PHP</h1>
    
    
    <form action="procesar.php" method="POST">
        <label for="nombre">Nombre de la variable:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        
        <label for="tipo">Tipo de dato:</label>
        <select id="tipo" name="tipo" required>
            <option value="texto">Texto</option>
            <option value="numero">Número</option>
            <option value="booleano">Booleano</option>
            <option value="constante">Constante</option>
            <option value="array">Array</option>
            <option value="suma">Suma de variables</option>
        </select><br><br>
        
        <label for="dato">Ingrese el valor:</label>
        
        <input type="text" id="dato" name="dato"><br><br>
        
        <!-- Campos para la suma de variables -->
        <div id="campos-suma" style="display: none;">
            <label for="variable1">Variable 1:</label>
            <input type="text" id="variable1" name="variable1"><br><br>

            <label for="variable2">Variable 2:</label>
            <input type="text" id="variable2" name="variable2"><br><br>
        </div>
        
        <button type="submit">Enviar</button>
    </form>
    
    <br>
    <br>

    <pre>
<?php
    // Lee el contenido del archivo codigo.php
    $codigo = htmlspecialchars(file_get_contents('codigo.php'));
    echo $codigo;
?>
    </pre>
    
    <style>
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            overflow-x: auto;
        }
    </style>
    
    <br>
    <br>
    
    <h1>Funciones</h1>

    <form action="funciones.php" method="POST">
        <label for="ingresar">Valor a Ingresar:</label>
        <input type="text" id="ingresar" name="ingresar" required><br><br>
        
        <label for="funcion">Tipo de funcion:</label>
        <select id="funcion" name="funcion" required>
            <option value="empty-f">Empty</option>
            <option value="unset-f">Unset</option>
            <option value="isset-f">Isset</option>
            <option value="count-f">Count</option>
            <option value="print_r-f">Print_r</option>
            <option value="echo-f">Echo</option>
        </select><br><br>

        <button type="submit">Enviar</button>
    </form>
    
    <br>
    <br>
    
    <h1>Condicionales</h1>
    
    <form action="condicionales.php" method="POST">
        <label for="condicion-1">Condicion 1:</label>
        <input type="text" id="condicion-1" name="condicion-1" required><br><br>
        <label for="condicion-2">Condicion 2:</label>
        <input type="text" id="condicion-2" name="condicion-2" required><br><br>
        <label for="respuesta">Respuesta:</label>
        <input type="text" id="respuesta" name="respuesta"><br><br>
        
        <label for="funcion-c">Tipo de funcion:</label>
        <select id="funcion-c" name="funcion-c" required>
            <option value="if-f">If</option>
            <option value="for-f">For</option>
            <option value="while-f">While</option>
        </select><br><br>

        <button type="submit">Enviar</button>
    </form>


    <!-- Script para mostrar u ocultar campos de suma según el tipo seleccionado -->
    <script>
        document.getElementById('tipo').addEventListener('change', function() {
            var tipo = this.value;
            var camposSuma = document.getElementById('campos-suma');
            var datoInput = document.getElementById('dato');
            if (tipo === 'suma') {
                camposSuma.style.display = 'block';
                datoInput.disabled = true;
            } else {
                camposSuma.style.display = 'none';
                datoInput.disabled = false;
            }
        });
        
    </script>

    <hr>
</body>
</html>
