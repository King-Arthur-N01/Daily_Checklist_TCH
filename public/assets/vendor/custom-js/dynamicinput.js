$(document).ready(function() {
    document.getElementById("addRowBtn").addEventListener("click", function (event) {
        event.preventDefault();
        addRow();
    });

    document.getElementById("removeRowBtn").addEventListener("click", function (event) {
        event.preventDefault();
        removeRow();
    });

    let rowCount = 1;

    function addRow() {
        const tableBody = document.getElementById("tableBody");
        const newRow = tableBody.insertRow(-1);
        rowCount++;
        const rowIdSuffix = rowCount; // Unique suffix for each row
        newRow.innerHTML = `
            <td>
                <div id="inputContainerA_${rowIdSuffix}">
                    <div class="dynamic-input-group">
                        <input class="col-12" type="text" name="bagian_yang_dicheck[]" placeholder="Example : Push Button">
                        <a class="btn btn-success btn-circle btn-sm" id="addColumnBtnA_${rowIdSuffix}"><i class="fas fa-plus"></i></a>
                        <a class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainerA_${rowIdSuffix}')"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </td>
            <td>
                <div id="inputContainerB_${rowIdSuffix}">
                    <div class="dynamic-input-group">
                        <input class="col-12" type="text" name="standart_parameter[]" placeholder="Example : Berfungsi dengan baik">
                        <a class="btn btn-success btn-circle btn-sm" id="addColumnBtnB_${rowIdSuffix}"><i class="fas fa-plus"></i></a>
                        <a class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainerB_${rowIdSuffix}')"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </td>
            <td>
                <div id="inputContainerC_${rowIdSuffix}">
                    <div class="dynamic-input-group">
                        <input class="col-12" type="text" name="metode_pengecekan[]" placeholder="Example : Dioperasikan">
                        <a class="btn btn-success btn-circle btn-sm" id="addColumnBtnC_${rowIdSuffix}"><i class="fas fa-plus"></i></a>
                        <a class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainerC_${rowIdSuffix}')"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </td>
            <td>
                <button type="button" id="addRowBtn_${rowIdSuffix}">Add Row</button>
                <button type="button" id="removeRowBtn_${rowIdSuffix}">Delete Row</button>
            </td>
        `;

        attachEventListeners(newRow, rowIdSuffix);
    }

    function attachEventListeners(row, rowIdSuffix) {
        row.querySelector(`#addColumnBtnA_${rowIdSuffix}`).addEventListener("click", function (event) {
            event.preventDefault();
            addInput(`inputContainerA_${rowIdSuffix}`, "bagian_yang_dicheck[]", "Example: Push Button");
        });

        row.querySelector(`#addColumnBtnB_${rowIdSuffix}`).addEventListener("click", function (event) {
            event.preventDefault();
            addInput(`inputContainerB_${rowIdSuffix}`, "standart_parameter[]", "Example: Berfungsi dengan baik");
        });

        row.querySelector(`#addColumnBtnC_${rowIdSuffix}`).addEventListener("click", function (event) {
            event.preventDefault();
            addInput(`inputContainerC_${rowIdSuffix}`, "metode_pengecekan[]", "Example: Dioperasikan");
        });

        row.querySelector(`#addRowBtn_${rowIdSuffix}`).addEventListener("click", function (event) {
            event.preventDefault();
            addRow();
        });

        row.querySelector(`#removeRowBtn_${rowIdSuffix}`).addEventListener("click", function (event) {
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

    document.getElementById("addColumnBtnA").addEventListener("click", function (event) {
        event.preventDefault();
        addInput("inputContainerA_1", "bagian_yang_dicheck[]", "Example: Push Button");
    });

    document.getElementById("addColumnBtnB").addEventListener("click", function (event) {
        event.preventDefault();
        addInput("inputContainerB_1", "standart_parameter[]", "Example: Berfungsi dengan baik");
    });

    document.getElementById("addColumnBtnC").addEventListener("click", function (event) {
        event.preventDefault();
        addInput("inputContainerC_1", "metode_pengecekan[]", "Example: Dioperasikan");
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
            event.preventDefault();
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
        const inputContainer = document.getElementById(containerId);
        if (inputContainer) {
            const inputGroups = inputContainer.querySelectorAll(".dynamic-input-group");
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
});
