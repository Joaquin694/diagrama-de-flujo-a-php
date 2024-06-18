document.addEventListener("DOMContentLoaded", function() {
    var $ = go.GraphObject.make;

    var myDiagram =
        $(go.Diagram, "diagramDiv", {
            initialContentAlignment: go.Spot.Center,
            "undoManager.isEnabled": true
        });

    // Define a simple node template
    myDiagram.nodeTemplate =
        $(go.Node, "Auto",
            new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
            $(go.Shape, "RoundedRectangle", { fill: "white", portId: "", cursor: "pointer" }),
            $(go.TextBlock, { margin: 8 },
                new go.Binding("text", "key")),
            // Panel de datos para mostrar información adicional
            $(go.Panel, "Table",
                { defaultAlignment: go.Spot.Left },
                $(go.RowColumnDefinition, { column: 1, width: 4 }),
                $(go.TextBlock, "Nombre: ", { row: 1, column: 0 }),
                $(go.TextBlock, { name: "nombre", row: 1, column: 1, margin: 3 },
                    new go.Binding("text", "nombre")),
                $(go.TextBlock, "Tipo: ", { row: 2, column: 0 }),
                $(go.TextBlock, { name: "tipo", row: 2, column: 1, margin: 3 },
                    new go.Binding("text", "tipo")),
                $(go.TextBlock, "Valor: ", { row: 3, column: 0 }),
                $(go.TextBlock, { name: "valor", row: 3, column: 1, margin: 3 },
                    new go.Binding("text", "valor"))
            )
        );

    // Define a simple link template with an arrow
    myDiagram.linkTemplate =
        $(go.Link,
            { routing: go.Link.Orthogonal, corner: 5 },
            $(go.Shape, { stroke: "black", strokeWidth: 1.5 }),
            $(go.Shape, { toArrow: "Standard", stroke: null })
        );

    // Create an initial model with a few nodes and links
    myDiagram.model = new go.GraphLinksModel(
        [
            { key: "Alpha", loc: "0 0", nombre: "Variable1", tipo: "texto", valor: "Ejemplo1" },
            { key: "Beta", loc: "150 0", nombre: "Variable2", tipo: "numero", valor: "100" },
            { key: "Gamma", loc: "0 150", nombre: "Variable3", tipo: "booleano", valor: "true" }
        ],
        [
            { from: "Alpha", to: "Beta" },
            { from: "Beta", to: "Gamma" }
        ]
    );

    // Function to add a new node with data from the variables form
    function addNodeFromVariablesForm(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        var nombre = document.getElementById('nombre').value;
        var tipo = document.getElementById('tipo').value;
        var valor = document.getElementById('dato').value;
        if (tipo === 'suma') {
            var variable1 = document.getElementById('variable1').value;
            var variable2 = document.getElementById('variable2').value;
            valor = `Suma de ${variable1} y ${variable2}`;
        }

        myDiagram.startTransaction("addNode");
        myDiagram.model.addNodeData({ key: nombre, loc: "300 150", nombre: nombre, tipo: tipo, valor: valor });
        myDiagram.commitTransaction("addNode");

        // Limpiar formulario después de agregar nodo
        document.getElementById('dataForm').reset();
    }

    // Function to add a new node with data from the function form
    function addNodeFromFunctionForm(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        var nombre = document.getElementById('nombre-funcion').value;
        var tipoFuncion = document.getElementById('tipo-funcion').value;

        myDiagram.startTransaction("addNode");
        myDiagram.model.addNodeData({ key: nombre, loc: "300 150", nombre: nombre, tipo: "función", valor: tipoFuncion });
        myDiagram.commitTransaction("addNode");

        // Limpiar formulario después de agregar nodo
        document.getElementById('functionForm').reset();
    }

    // Function to add a new node with data from the conditional form
    function addNodeFromConditionalForm(event) {
        event.preventDefault(); // Evitar el envío del formulario por defecto

        var condicion1 = document.getElementById('condicion-1').value;
        var condicion2 = document.getElementById('condicion-2').value;
        var respuesta = document.getElementById('respuesta').value;
        var tipoCondicional = document.getElementById('tipo-condicional').value;

        myDiagram.startTransaction("addNode");
        myDiagram.model.addNodeData({ key: `Cond_${condicion1}_${condicion2}`, loc: "300 150", nombre: "Condición", tipo: tipoCondicional, valor: `Si ${condicion1} entonces ${respuesta} sino ${condicion2}` });
        myDiagram.commitTransaction("addNode");

        // Limpiar formulario después de agregar nodo
        document.getElementById('conditionForm').reset();
    }

    // Event listener for variables form submission
    document.getElementById("dataForm").addEventListener("submit", addNodeFromVariablesForm);

    // Event listener for function form submission
    document.getElementById("functionForm").addEventListener("submit", addNodeFromFunctionForm);

    // Event listener for conditional form submission
    document.getElementById("conditionForm").addEventListener("submit", addNodeFromConditionalForm);

});

