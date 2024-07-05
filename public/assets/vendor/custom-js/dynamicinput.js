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
        let inputGroupCount = 1;
        newRow.innerHTML =`
            <td id="columnContainerA_${rowIdSuffix}">
                <div class="dynamic-input-group" id="inputContainerA_${rowIdSuffix}_${inputGroupCount}">
                    <input type="text" name="bagian_yang_dicheck[]" id="componencheck_${rowIdSuffix}_${inputGroupCount}" placeholder="Example : Push Button">
                </div>
            </td>
            <td id="columnContainerB_${rowIdSuffix}">
                <div class="dynamic-input-group" id="inputContainerB_${rowIdSuffix}_${inputGroupCount}">
                    <input type="text" name="standart_parameter[]" id="parameter_${rowIdSuffix}_${inputGroupCount}" placeholder="Example : Berfungsi dengan baik">
                    <a class="btn btn-success btn-circle btn-sm" id="addColumnBtnB_${rowIdSuffix}_${inputGroupCount}"><i class="fas fa-plus"></i></a>
                    <a class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnB_${rowIdSuffix}_${inputGroupCount}"><i class="fas fa-trash-alt"></i></a>
                </div>
            </td>
            <td id="columnContainerC_${rowIdSuffix}">
                <div class="dynamic-input-group" id="inputContainerC_${rowIdSuffix}_${inputGroupCount}">
                    <input type="text" name="metode_pengecekan[]" id="metodecheck_${rowIdSuffix}_${inputGroupCount}" placeholder="Example : Dioperasikan">
                    <a class="btn btn-success btn-circle btn-sm" id="addColumnBtnC_${rowIdSuffix}_${inputGroupCount}"><i class="fas fa-plus"></i></a>
                    <a class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnC_${rowIdSuffix}_${inputGroupCount}"><i class="fas fa-trash-alt"></i></a>
                </div>
            </td>
            <td>
                <div class="dynamic-input-group action-buttons">
                    <button type="button" class="btn btn-success btn-sm" id="addRowBtn">Add Row</button>
                    <button type="button" class="btn btn-danger btn-sm" id="removeRowBtn">Delete Row</button>
                </div>
            </td>
        `;

        attachEventListeners(newRow,rowIdSuffix);
    }

    function attachEventListeners(row, rowIdSuffix,) {

        let inputGroupCount = 1;

        const addColumnBtnB = row.querySelector(`#addColumnBtnB_${rowIdSuffix}_${inputGroupCount}`);
        if (addColumnBtnB) {
            addColumnBtnB.addEventListener("click", function (event) {
                event.preventDefault();
                inputGroupCount++;
                addInput(`inputContainerB_${rowIdSuffix}_${inputGroupCount}`, "bagian_yang_dicheck[]", "Example: Push Button");
            });
        }

        const addColumnBtnC = row.querySelector(`#addColumnBtnC_${rowIdSuffix}_${inputGroupCount}`);
        if (addColumnBtnC) {
            addColumnBtnC.addEventListener("click", function (event) {
                event.preventDefault();
                inputGroupCount++;
                addInput(`inputContainerC_${rowIdSuffix}_${inputGroupCount}`, "metode_pengecekan[]", "Example: Dioperasikan");
            });
        }
        row.querySelector(`#addColumnBtnB_${rowIdSuffix}_${inputGroupCount}`).addEventListener("click", function (event) {
            event.preventDefault();
        });

        row.querySelector(`#addColumnBtnC_${rowIdSuffix}_${inputGroupCount}`).addEventListener("click", function (event) {
            event.preventDefault();
        });

        row.querySelector(`#addRowBtn`).addEventListener("click", function (event) {
            event.preventDefault();
            addRow();
        });

        row.querySelector(`#removeRowBtn`).addEventListener("click", function (event) {
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

    document.getElementById("addColumnBtnB_1_1").addEventListener("click", function (event) {
        event.preventDefault();
        addInput("columnContainerB_1", "standart_parameter[]", "parameter_1_1", "Example: Berfungsi dengan baik");
    });

    document.getElementById("addColumnBtnC_1_1").addEventListener("click", function (event) {
        event.preventDefault();
        addInput("columnContainerC_1", "metode_pengecekan[]", "metodecheck_1_1", "Example: Dioperasikan");
    });

    function addInput(containerId, inputName, inputId, placeholder) {
        const inputContainer = document.getElementById(containerId);
        const newInputGroup = document.createElement("div");
        newInputGroup.className = "dynamic-input-group";

        const newInput = document.createElement("input");
        newInput.type = "text";
        newInput.name = inputName;
        newInput.id = inputId;
        newInput.placeholder = placeholder;

        const addButton = document.createElement("button");
        addButton.type = "button";
        addButton.className = "btn btn-success btn-circle btn-sm";
        addButton.innerHTML = '<i class="fas fa-plus"></i>';
        addButton.addEventListener("click", function (event) {
            event.preventDefault();
            addInput(containerId, inputName, inputId, placeholder);
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
