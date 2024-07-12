document.addEventListener("DOMContentLoaded", function() {
    const addRowBtn = document.getElementById("addRowBtn");
    const removeRowBtn = document.getElementById("removeRowBtn");

    if (addRowBtn) {
        addRowBtn.addEventListener("click", function (event) {
            event.preventDefault();
            addRow();
        });
    }

    if (removeRowBtn) {
        removeRowBtn.addEventListener("click", function (event) {
            event.preventDefault();
            removeRow();
        });
    }

    let rowCount = 1;
    const inputCounts = {1: {A: 1, B: 1, C: 1}};

    function addRow() {
        const tableBody = document.getElementById("tableBody");
        const newRow = tableBody.insertRow(-1);
        rowCount++;
        const rowIdSuffix = rowCount;
        inputCounts[rowIdSuffix] = {A: 1, B: 1, C: 1};

        newRow.innerHTML =`
            <td id="columnContainerA_${rowIdSuffix}">
                <div class="dynamic-input-group" id="inputContainerA_${rowIdSuffix}_1">
                    <textarea type="text" class="form-control" style="height: 100px;" name="bagian_yang_dicheck[]" id="componencheck_${rowIdSuffix}_1" placeholder="Example : Push Button"></textarea>
                    <input type="hidden" name="total_user_input" id="userInputCount_${rowIdSuffix}" value="1">
                </div>
            </td>
            <td id="columnContainerB_${rowIdSuffix}">
                <div class="dynamic-input-group" id="inputContainerB_${rowIdSuffix}_1">
                    <input type="text" class="form-control form-control-user" name="standart_parameter[]" id="parameter_${rowIdSuffix}_1" placeholder="Example : Berfungsi dengan baik">
                    <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnB_${rowIdSuffix}_1"><i class="fas fa-plus"></i></button>
                    <button type="button" class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnB_${rowIdSuffix}_1"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
            <td id="columnContainerC_${rowIdSuffix}">
                <div class="dynamic-input-group" id="inputContainerC_${rowIdSuffix}_1">
                    <input type="text" class="form-control form-control-user" name="metode_pengecekan[]" id="metodecheck_${rowIdSuffix}_1" placeholder="Example : Dioperasikan">
                    <button type="button" class="btn btn-success btn-circle btn-sm" id="addColumnBtnC_${rowIdSuffix}_1"><i class="fas fa-plus"></i></button>
                    <button type="button" class="btn btn-danger btn-circle btn-sm" id="removeColumnBtnC_${rowIdSuffix}_1"><i class="fas fa-trash-alt"></i></button>
                </div>
            </td>
            <td>
                <div class="dynamic-button-group">
                    <button type="button" class="btn btn-success btn-sm addRowBtn">Add Rows</button>
                    <button type="button" class="btn btn-danger btn-sm removeRowBtn">Delete Rows</button>
                </div>
            </td>
        `;

        attachEventListeners(newRow, rowIdSuffix);
    }

    function attachEventListeners(row, rowIdSuffix) {
        row.querySelector(`#addColumnBtnB_${rowIdSuffix}_1`).addEventListener("click", function (event) {
            event.preventDefault();
            addInput(`columnContainerB_${rowIdSuffix}`, "standart_parameter[]", `parameter_${rowIdSuffix}`, "Example: Berfungsi dengan baik", rowIdSuffix, 'B');
        });

        row.querySelector(`#addColumnBtnC_${rowIdSuffix}_1`).addEventListener("click", function (event) {
            event.preventDefault();
            addInput(`columnContainerC_${rowIdSuffix}`, "metode_pengecekan[]", `metodecheck_${rowIdSuffix}`, "Example: Dioperasikan", rowIdSuffix, 'C');
        });

        row.querySelector(`#removeColumnBtnB_${rowIdSuffix}_1`).addEventListener("click", function (event) {
            event.preventDefault();
            removeInput(this, `columnContainerB_${rowIdSuffix}`);
        });

        row.querySelector(`#removeColumnBtnC_${rowIdSuffix}_1`).addEventListener("click", function (event) {
            event.preventDefault();
            removeInput(this, `columnContainerC_${rowIdSuffix}`);
        });

        row.querySelector(".addRowBtn").addEventListener("click", function (event) {
            event.preventDefault();
            addRow();
        });

        row.querySelector(".removeRowBtn").addEventListener("click", function (event) {
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
        addInput("columnContainerB_1", "standart_parameter[]", "parameter_1", "Example: Berfungsi dengan baik", 1, 'B');
    });

    document.getElementById("addColumnBtnC_1_1").addEventListener("click", function (event) {
        event.preventDefault();
        addInput("columnContainerC_1", "metode_pengecekan[]", "metodecheck_1", "Example: Dioperasikan", 1, 'C');
    });

    document.getElementById("removeColumnBtnB_1_1").addEventListener("click", function (event) {
        event.preventDefault();
        removeInput(this, `inputContainerB_1_1`);
    });

    document.getElementById("removeColumnBtnC_1_1").addEventListener("click", function (event) {
        event.preventDefault();
        removeInput(this, `inputContainerC_1_1`);
    });

    function addInput(containerId, inputName, inputIdPrefix, placeholder, rowIdSuffix, columnId) {
        const inputContainer = document.getElementById(containerId);
        if (!inputCounts[rowIdSuffix]) {
            inputCounts[rowIdSuffix] = {A: 1, B: 1, C: 1};
        }
        const inputGroupCount = ++inputCounts[rowIdSuffix][columnId];
        const newInputGroup = document.createElement("div");
        newInputGroup.className = "dynamic-input-group";

        const newInput = document.createElement("input");
        newInput.type = "text";
        newInput.className = "form-control form-control-user";
        newInput.name = inputName;
        newInput.id = `${inputIdPrefix}_${inputGroupCount}`;
        newInput.placeholder = placeholder;

        const addButton = document.createElement("button");
        addButton.type = "button";
        addButton.className = "btn btn-success btn-circle btn-sm";
        addButton.innerHTML = '<i class="fas fa-plus"></i>';
        addButton.addEventListener("click", function (event) {
            event.preventDefault();
            addInput(containerId, inputName, inputIdPrefix, placeholder, rowIdSuffix, columnId);
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

        // Increment the hidden input value
        document.getElementById(`userInputCount_${rowIdSuffix}`).value = inputGroupCount;
    }

    function removeInput(button, containerId) {
        const inputContainer = document.getElementById(containerId);
        if (inputContainer) {
            const inputGroups = inputContainer.querySelectorAll(".dynamic-input-group");
            if (inputGroups.length > 1) {
                const inputGroup = button.parentNode;
                inputGroup.parentNode.removeChild(inputGroup);

                // Decrement the hidden input value
                const rowIdSuffix = containerId.split('_').pop();
                const currentCount = parseInt(document.getElementById(`userInputCount_${rowIdSuffix}`).value, 10);
                document.getElementById(`userInputCount_${rowIdSuffix}`).value = currentCount - 1;
            } else {
                alert("At least one input must remain.");
            }
        } else {
            console.error(`Element with id "${containerId}" not found`);
        }
    }
});
