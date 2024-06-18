<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagrama de Flujo con GoJS</title>
    <script src="https://unpkg.com/gojs/release/go.js"></script>
    <style>
        #diagramDiv {
            width: 100%;
            height: 600px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div id="diagramDiv"></div>

    <!-- Formulario para variables -->
    <form id="dataForm">
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
        
        <button type="submit">Agregar Nodo</button>
    </form>

    <hr>

    <!-- Formulario para funciones -->
    <form id="functionForm">
        <label for="nombre-funcion">Nombre de la función:</label>
        <input type="text" id="nombre-funcion" name="nombre-funcion" required><br><br>
        
        <label for="tipo-funcion">Tipo de función:</label>
        <select id="tipo-funcion" name="tipo-funcion" required>
            <option value="empty-f">Empty</option>
            <option value="unset-f">Unset</option>
            <option value="isset-f">Isset</option>
            <option value="count-f">Count</option>
            <option value="print_r-f">Print_r</option>
            <option value="echo-f">Echo</option>
        </select><br><br>

        <button type="submit">Agregar Función</button>
    </form>

    <hr>

    <!-- Formulario para condicionales -->
    <form id="conditionForm">
        <label for="condicion-1">Condición 1:</label>
        <input type="text" id="condicion-1" name="condicion-1" required><br><br>
        
        <label for="condicion-2">Condición 2:</label>
        <input type="text" id="condicion-2" name="condicion-2" required><br><br>
        
        <label for="respuesta">Respuesta:</label>
        <input type="text" id="respuesta" name="respuesta"><br><br>
        
        <label for="tipo-condicional">Tipo de condicional:</label>
        <select id="tipo-condicional" name="tipo-condicional" required>
            <option value="if-f">If</option>
            <option value="for-f">For</option>
            <option value="while-f">While</option>
        </select><br><br>

        <button type="submit">Agregar Condicional</button>
    </form>

    <script src="script.js"></script>
</body>
</html>

