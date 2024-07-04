$(document).ready(function() {
    document.getElementById("addRowBtn").addEventListener("click", function (event) {
        event.preventDefault();
        addRow();
    });

    document.getElementById("removeRowBtn").addEventListener("click", function (event) {
        event.preventDefault();
        removeRow();
    });

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

    let rowCount = 1;

    function addRow() {
        const tableBody = document.getElementById("tableBody");
        const newRow = tableBody.insertRow(-1);
        rowCount++;
        const rowIdSuffix = rowCount; // Unique suffix for each row
        let inputGroupCount = 1; // Reset input group count for each new row

        newRow.innerHTML = `
            <td>
                <div id="inputContainerA_${rowIdSuffix}_${inputGroupCount}">
                    <div class="dynamic-input-group">
                        <input class="col-12" type="text" name="bagian_yang_dicheck[]" placeholder="Example : Push Button">
                        <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnA_${rowIdSuffix}_${inputGroupCount}"><i class="fas fa-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainerA_${rowIdSuffix}_${inputGroupCount}')"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
            </td>
            <td>
                <div id="inputContainerB_${rowIdSuffix}_${inputGroupCount}">
                    <div class="dynamic-input-group">
                        <input class="col-12" type="text" name="standart_parameter[]" placeholder="Example : Berfungsi dengan baik">
                        <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnB_${rowIdSuffix}_${inputGroupCount}"><i class="fas fa-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainerB_${rowIdSuffix}_${inputGroupCount}')"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
            </td>
            <td>
                <div id="inputContainerC_${rowIdSuffix}_${inputGroupCount}">
                    <div class="dynamic-input-group">
                        <input class="col-12" type="text" name="metode_pengecekan[]" placeholder="Example : Dioperasikan">
                        <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnC_${rowIdSuffix}_${inputGroupCount}"><i class="fas fa-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-circle btn-sm" onclick="removeInput(this, 'inputContainerC_${rowIdSuffix}_${inputGroupCount}')"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
            </td>
            <td>
                <button type="button" id="addRowBtn_${rowIdSuffix}">Add Row</button>
                <button type="button" id="removeRowBtn_${rowIdSuffix}">Delete Row</button>
            </td>
        `;

        const inputContainerA = document.getElementById(`inputContainerA_${rowIdSuffix}_${inputGroupCount}`);
        if (inputContainerA) {
            inputContainerA.innerHTML = '';
            addInput(`inputContainerA_${rowIdSuffix}_${inputGroupCount}`, "bagian_yang_dicheck[]", "Example: Push Button");
        }

        const inputContainerB = document.getElementById(`inputContainerB_${rowIdSuffix}_${inputGroupCount}`);
        if (inputContainerB) {
            inputContainerB.innerHTML = '';
            addInput(`inputContainerB_${rowIdSuffix}_${inputGroupCount}`, "standart_parameter[]", "Example: Berfungsi dengan baik");
        }

        const inputContainerC = document.getElementById(`inputContainerC_${rowIdSuffix}_${inputGroupCount}`);
        if (inputContainerC) {
            inputContainerC.innerHTML = '';
            addInput(`inputContainerC_${rowIdSuffix}_${inputGroupCount}`, "metode_pengecekan[]", "Example: Dioperasikan");
        }

        // Add event listeners after creating the elements
        attachEventListeners(newRow, rowIdSuffix);
    }

    function attachEventListeners(row, rowIdSuffix) {
        let inputGroupCount = 1;

        const addColumnBtnA = row.querySelector(`#addColumnBtnA_${rowIdSuffix}_${inputGroupCount}`);
        if (addColumnBtnA) {
            addColumnBtnA.addEventListener("click", function (event) {
                event.preventDefault();
                inputGroupCount++;
                addInput(`inputContainerA_${rowIdSuffix}_${inputGroupCount}`, "bagian_yang_dicheck[]", "Example: Push Button");
            });
        }

        const addColumnBtnB = row.querySelector(`#addColumnBtnB_${rowIdSuffix}_${inputGroupCount}`);
        if (addColumnBtnB) {
            addColumnBtnB.addEventListener("click", function (event) {
                event.preventDefault();
                inputGroupCount++;
                addInput(`inputContainerB_${rowIdSuffix}_${inputGroupCount}`, "standart_parameter[]", "Example: Berfungsi dengan baik");
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

        const addRowBtn = row.querySelector(`#addRowBtn_${rowIdSuffix}`);
        if (addRowBtn) {
            addRowBtn.addEventListener("click", function (event) {
                event.preventDefault();
                addRow();
            });
        }

        const removeRowBtn = row.querySelector(`#removeRowBtn_${rowIdSuffix}`);
        if (removeRowBtn) {
            removeRowBtn.addEventListener("click", function (event) {
                event.preventDefault();
                removeRow();
            });
        }
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

    document.getElementById("addColumnBtnA_1_1").addEventListener("click", function (event) {
        event.preventDefault();
        addInput("inputContainerA_1_1", "bagian_yang_dicheck[]", "Example: Push Button");
    });

    document.getElementById("addColumnBtnB_1_1").addEventListener("click", function (event) {
        event.preventDefault();
        addInput("inputContainerB_1_1", "standart_parameter[]", "Example: Berfungsi dengan baik");
    });

    document.getElementById("addColumnBtnC_1_1").addEventListener("click", function (event) {
        event.preventDefault();
        addInput("inputContainerC_1_1", "metode_pengecekan[]", "Example: Dioperasikan");
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
});
