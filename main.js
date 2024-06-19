document.addEventListener("DOMContentLoaded", function() {
        var $ = go.GraphObject.make;

        var myDiagram = $(go.Diagram, "diagramDiv", {
            initialContentAlignment: go.Spot.Center,
            "undoManager.isEnabled": true,
            "clickCreatingTool.archetypeNodeData": { key: "NuevoNodo", loc: "0 0", nombre: "Nuevo Nodo", tipo: "texto", valor: "" }
        });

        // Define a simple node template
        myDiagram.nodeTemplate = $(go.Node, "Auto",
            new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
            $(go.Shape, "RoundedRectangle", { fill: "white", portId: "", cursor: "pointer" }),
            $(go.TextBlock, { margin: 8 },
                new go.Binding("text", "key")),
            // Panel de datos para mostrar información adicional
            $(go.Panel, "Table", { defaultAlignment: go.Spot.Left },
                $(go.RowColumnDefinition, { column: 8, width: 8 }),
                $(go.TextBlock, "Tipo: ", { row: 2, column: 0 }),
                $(go.TextBlock, { name: "tipo", row: 2, column: 1, margin: 3 },
                    new go.Binding("text", "tipo")),
                $(go.TextBlock, "Valor: ", { row: 3, column: 0 }),
                $(go.TextBlock, { name: "valor", row: 3, column: 1, margin: 3 },
                    new go.Binding("text", "valor"))
            )
        );

        // Define a simple link template with an arrow
        myDiagram.linkTemplate = $(go.Link,
            { routing: go.Link.Orthogonal, corner: 5 },
            $(go.Shape, { stroke: "black", strokeWidth: 1.5 }),
            $(go.Shape, { toArrow: "Standard", stroke: null })
        );

        // Function to handle context menu display
        function showContextMenu(e, obj) {
            var contextMenu = document.getElementById("contextMenu");
            contextMenu.style.left = (e.event.clientX - 10) + "px"; // Ajusta la posición izquierda del menú
            contextMenu.style.top = (e.event.clientY - 10) + "px"; // Ajusta la posición superior del menú
            contextMenu.style.display = "block";
            contextMenu.dataset.node = obj.part.data.key; // Guarda el key del nodo seleccionado
            e.diagram.currentTool.stopTool(); // Detiene cualquier tool en uso actualmente
        }
        // Event listener para confirmar la entrada de variable
	document.getElementById("confirmVariable").addEventListener("click", function() {
    var variableName = document.getElementById("variableNameInput").value;
    var variableData = document.getElementById("variableDataInput").value;
    
    // Enviamos los datos al archivo PHP usando fetch
	fetch('generate_and_save_php.php', {
	    method: 'POST',
	    headers: {
	        'Content-Type': 'application/x-www-form-urlencoded',
	    },
	    body: 'variableName=' + encodeURIComponent(variableName) + '&variableData=' + encodeURIComponent(variableData)
	})
	.then(response => {
	    if (!response.ok) {
	        throw new Error('Network response was not ok');
	    }
	    console.log('Datos de variable enviados correctamente.');
	})
	.catch(error => {
	    console.error('Error al enviar datos de variable:', error);
	});

	hideContextMenu();
	resetInput("variableNameInput");
	resetInput("variableDataInput");
    });

    // Event listener para confirmar la entrada de array
    document.getElementById("confirmArray").addEventListener("click", function() {
	var arrayName = document.getElementById("arrayNameInput").value;
	var arrayData = document.getElementById("arrayDataInput").value;

	// Enviamos los datos al archivo PHP usando fetch
	fetch('generate_and_save_php.php', {
	    method: 'POST',
	    headers: {
	        'Content-Type': 'application/x-www-form-urlencoded',
	    },
	    body: 'arrayName=' + encodeURIComponent(arrayName) + '&arrayData=' + encodeURIComponent(arrayData)
	})
	.then(response => {
	    if (!response.ok) {
	        throw new Error('Network response was not ok');
	    }
	    console.log('Datos de array enviados correctamente.');
	})
	.catch(error => {
	    console.error('Error al enviar datos de array:', error);
	});

	hideContextMenu();
	resetInput("arrayNameInput");
	resetInput("arrayDataInput");
    });
        
document.getElementById("addVariableNode").addEventListener("click", function() {
	var variableInput = document.getElementById("variableInput");
	variableInput.style.display = "block";
    });

    // Event listener para confirmar la entrada de variable
  document.getElementById("confirmVariable").addEventListener("click", function() {
	var variableName = document.getElementById("variableNameInput").value;
	var variableData = document.getElementById("variableDataInput").value;
	addNode("NuevoNodo", "Variable", "variable", "$" + variableName + " = " + variableData);
	hideContextMenu();
	resetInput("variableNameInput");
	resetInput("variableDataInput");
    });

    // Event listener para cancelar la entrada de variable
  document.getElementById("cancelVariable").addEventListener("click", function() {
	resetInput("variableNameInput");
	resetInput("variableDataInput");
	hideSubMenu("menuVariables");
    });

    // Event listener para mostrar el campo de entrada cuando se selecciona "Agregar Array"
  document.getElementById("addArrayNode").addEventListener("click", function() {
	var arrayInput = document.getElementById("arrayInput");
	arrayInput.style.display = "block";
    });

    // Event listener para confirmar la entrada de array
  document.getElementById("confirmArray").addEventListener("click", function() {
	var arrayName = document.getElementById("arrayNameInput").value;
	var arrayData = document.getElementById("arrayDataInput").value.split(",").map(item => item.trim()).join(", ");
	addNode("NuevoNodo", "Array", "array", "$" + arrayName + " = [" + arrayData + "]");
	hideContextMenu();
	resetInput("arrayNameInput");
	resetInput("arrayDataInput");
    });

    // Event listener para cancelar la entrada de array
  document.getElementById("cancelArray").addEventListener("click", function() {
	resetInput("arrayNameInput");
	resetInput("arrayDataInput");
	hideSubMenu("menuVariables");
    });

    document.getElementById("addFunctionNode").addEventListener("click", function() {
    showSubMenu("functionSubMenu");
});

document.getElementById("addConditionalNode").addEventListener("click", function() {
    showSubMenu("conditionalSubMenu");
});


    // Event listeners para funciones específicas
    document.getElementById("addEchoFunction").addEventListener("click", function() {
	addNode("NuevoNodo", "Función", "echo", "");
	hideSubMenu("menuFunciones");
    });

    document.getElementById("addEmptyFunction").addEventListener("click", function() {
	addNode("NuevoNodo", "Función", "empty", "");
	hideSubMenu("menuFunciones");
    });

    // Event listeners para condicionales específicos
    document.getElementById("addIfConditional").addEventListener("click", function() {
	addNode("NuevoNodo", "Condición", "if", "");
	hideSubMenu("menuCondicional");
    });

    document.getElementById("addWhileConditional").addEventListener("click", function() {
	addNode("NuevoNodo", "Condición", "while", "");
	hideSubMenu("menuCondicional");
    });

    document.getElementById("addForConditional").addEventListener("click", function() {
	addNode("NuevoNodo", "Condicion", "for", "");
	hideSubMenu("menuCondicional");
    });


        // Function to add a new node
        function addNode(fromNodeKey, nombre, tipo, valor) {
            var newNodeKey = makeUniqueKey(); // Función para generar un key único
            myDiagram.model.addNodeData({ key: newNodeKey, loc: "300 150", nombre: nombre, tipo: tipo, valor: valor });
            myDiagram.model.addLinkData({ from: fromNodeKey, to: newNodeKey });
        }

        // Function to hide context menu
        function hideContextMenu() {
            var contextMenu = document.getElementById("contextMenu");
            contextMenu.style.display = "none";
        }

        // Function to show submenu
        function showSubMenu(menuId) {
            hideAllMenus();
            var menu = document.getElementById(menuId);
            menu.style.display = "block";
        }

        // Function to hide all menus
        function hideAllMenus() {
            var menus = document.querySelectorAll(".context-menu ul");
            menus.forEach(function(menu) {
                menu.style.display = "none";
            });
        }

        // Function to hide submenu
        function hideSubMenu(menuId) {
            var menu = document.getElementById(menuId);
            menu.style.display = "none";
        }

        // Event listener for showing context menu on diagram click
        myDiagram.contextClick = function(e, obj) {
            if (!obj) showContextMenu(e, obj);
        };

        // Function to generate unique keys for nodes
        function makeUniqueKey() {
            return "" + (myDiagram.model.nodeDataArray.length + 1);
        }
        
        function resetInput(inputId) {
        document.getElementById(inputId).value = "";
	    }
	    

});
