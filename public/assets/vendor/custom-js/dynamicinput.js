document.getElementById("addRowBtn").addEventListener("click", function (event) {
        event.preventDefault();
        addRow();
    });

document.getElementById("removeRowBtn").addEventListener("click", function (event) {
        event.preventDefault();
        removeRow();
    });

function addRow() {
    const tableBody = document.getElementById("tableBody");
    const newRow = tableBody.insertRow(-1);
    newRow.innerHTML = `
        <td>
            <div id="inputContainer1">
                <div class="dynamic-input-group">
                    <input class="col-12" type="text" name="bagian_yang_dicheck[]" placeholder="Example : Push Button">
                    <a class="btn btn-success btn-circle btn-sm" id="addColumnBtn1"><i class="fas fa-plus"></i></a>
                    <a class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainer1')"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        </td>
        <td>
            <div id="inputContainer2">
                <div class="dynamic-input-group" id="inputContainer2">
                    <input class="col-12" type="text" name="standart_parameter[]" placeholder="Example : Berfungsi dengan baik">
                    <a class="btn btn-success btn-circle btn-sm" id="addColumnBtn2"><i class="fas fa-plus"></i></a>
                    <a class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainer2')"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        </td>
        <td>
            <div id="inputContainer3">
                <div class="dynamic-input-group" id="inputContainer3">
                    <input class="col-12" type="text" name="metode_pengecekan[]" placeholder="Example : Dioperasikan">
                    <a class="btn btn-success btn-circle btn-sm" id="addColumnBtn3"><i class="fas fa-plus"></i></a>
                    <a class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainer3')"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        </td>
        <td>
            <button type="button" id="addRowBtn">Add Row</button>
            <button type="button" id="removeRowBtn">Delete Row</button>
        </td>
    `;

    // Attach event listeners to the newly created buttons
    const addColumnBtn1 = newRow.querySelector('#addColumnBtn1');
    addColumnBtn1.addEventListener("click", function (event) {
        event.preventDefault();
        addInput(
            "inputContainer1",
            "bagian_yang_dicheck[]",
            "Example: Push Button"
        );
    });

    const addColumnBtn2 = newRow.querySelector('#addColumnBtn2');
    addColumnBtn2.addEventListener("click", function (event) {
        event.preventDefault();
        addInput(
            "inputContainer2",
            "standart_parameter[]",
            "Example: Berfungsi dengan baik"
        );
    });

    const addColumnBtn3 = newRow.querySelector('#addColumnBtn3');
    addColumnBtn3.addEventListener("click", function (event) {
        event.preventDefault();
        addInput(
            "inputContainer3",
            "metode_pengecekan[]",
            "Example: Dioperasikan"
        );
    });

    const addRowBtn = newRow.querySelector('#addRowBtn');
    addRowBtn.addEventListener("click", function (event) {
        event.preventDefault();
        addRow();
    });

    const removeRowBtn = newRow.querySelector('#removeRowBtn');
    removeRowBtn.addEventListener("click", function (event) {
        event.preventDefault();
        removeRow();
    });
}

function removeRow() {
    const tableBody = document.getElementById("tableBody");
    const rows = tableBody.rows;
    if (rows.length > 1) {
        tableBody.deleteRow(-1);
    } else {
        alert("At least one row must remain.");
    }
}

document.getElementById("addColumnBtn1").addEventListener("click", function (event) {
        event.preventDefault();
        addInput(
            "inputContainer1",
            "bagian_yang_dicheck[]",
            "Example: Push Button"
        );
    });

document.getElementById("addColumnBtn2").addEventListener("click", function (event) {
        event.preventDefault();
        addInput(
            "inputContainer2",
            "standart_parameter[]",
            "Example: Berfungsi dengan baik"
        );
    });

document.getElementById("addColumnBtn3").addEventListener("click", function (event) {
        event.preventDefault();
        addInput(
            "inputContainer3",
            "metode_pengecekan[]",
            "Example: Dioperasikan"
        );
    });

function addInput(containerId, inputName, placeholder) {
    const inputContainer = document.getElementById(containerId);
    const newInputGroup = document.createElement("div");
    newInputGroup.className = "dynamic-input-group";

    const newInput = document.createElement("input");
    newInput.className = "col-12";
    newInput.type = "text";
    newInput.name = inputName;
    newInput.placeholder = placeholder;

    const addButton = document.createElement("button");
    addButton.type = "button";
    addButton.className = "btn btn-success btn-circle btn-sm";
    addButton.innerHTML = '<i class="fas fa-plus"></i>';
    addButton.addEventListener("click", function (event) {
        addInput(containerId, inputName, placeholder);
    });

    const removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.className = "btn btn-danger btn-circle btn-sm";
    removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
    removeButton.onclick = function () {
        removeInput(this, containerId);
    };

    newInputGroup.appendChild(newInput);
    newInputGroup.appendChild(addButton);
    newInputGroup.appendChild(removeButton);
    inputContainer.appendChild(newInputGroup);
}

function removeInput(button, containerId) {
    const inputContainer = button.parentNode.parentNode; // Get the parent element of the button
    if (inputContainer) {
        const inputGroups = inputContainer.querySelectorAll(
            ".dynamic-input-group"
        );
        if (inputGroups.length > 1) {
            const inputGroup = button.parentNode;
            inputGroup.parentNode.removeChild(inputGroup);
        } else {
            alert("At least one input must remain.");
        }
    } else {
        console.error(`Element with id "${containerId}" not found`);
    }
}
