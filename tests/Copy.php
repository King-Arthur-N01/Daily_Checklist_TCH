$('#updateModal').on('shown.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const propertyId = button.data('id');
    $.ajax({
        type: 'GET',
        url: '{{ route("findproperty", ":id") }}'.replace(':id', propertyId),
        success: function (data) {
            document.getElementById("namePropertyEdit").value = data.componentdata[0].name_property;
            document.getElementById("propertyId").value = data.componentdata[0].id;

            let tableBodyContent = '';
            data.componentdata.forEach((component, rowIndex) => {
                let newRow = `
                    <tr>
                        <td id="columnContainerA_${rowIndex + 1}_Edit">
                            <div class="dynamic-input-group">
                                <textarea type="text" class="form-control" style="height: 100px;" name="bagian_yang_dicheck[]" id="componencheck_${rowIndex + 1}_1_Edit" placeholder="Example : Push Button">${component.name_componencheck || ''}</textarea>
                            </div>
                        </td>
                        <td id="columnContainerB_${rowIndex + 1}_Edit">
                `;

                let parameterCount = 1;
                data.propertydata.forEach((item) => {
                    if (component.componen_id == item.join_id) {
                        newRow += `
                            <div class="dynamic-input-group" id="inputContainerB_${rowIndex + 1}_${parameterCount}_Edit">
                                <input type="text" class="form-control form-control-user" name="standart_parameter[]" id="parameter_${rowIndex + 1}_${parameterCount}_Edit" placeholder="Example : Berfungsi dengan baik" value="${item.name_parameter || ''}">
                                <button type="button" class="btn btn-success btn-circle btn-sm addEditColumnBtnB" data-row-id="${rowIndex + 1}"><i class="fas fa-plus"></i></button>
                                <button type="button" class="btn btn-danger btn-circle btn-sm removeEditColumnBtnB" data-row-id="${rowIndex + 1}"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        `;
                        parameterCount++;
                    }
                });

                newRow += `
                        </td>
                        <td id="columnContainerC_${rowIndex + 1}_Edit">
                `;

                let metodeCount = 1;
                data.propertydata.forEach((item) => {
                    if (component.componen_id == item.join_id) {
                        newRow += `
                            <div class="dynamic-input-group" id="inputContainerC_${rowIndex + 1}_${metodeCount}_Edit">
                                <input type="text" class="form-control form-control-user" name="metode_pengecekan[]" id="metodecheck_${rowIndex + 1}_${metodeCount}_Edit" placeholder="Example : Dioperasikan" value="${item.name_metodecheck || ''}">
                                <button type="button" class="btn btn-success btn-circle btn-sm addEditColumnBtnC" data-row-id="${rowIndex + 1}"><i class="fas fa-plus"></i></button>
                                <button type="button" class="btn btn-danger btn-circle btn-sm removeEditColumnBtnC" data-row-id="${rowIndex + 1}"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        `;
                        metodeCount++;
                    }
                });

                newRow += `
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm addEditRowBtn">Add Row</button>
                            <button type="button" class="btn btn-danger btn-sm removeEditRowBtn">Remove Row</button>
                        </td>
                    </tr>
                `;
                tableBodyContent += newRow;
            });

            $('#editTableBody').html(tableBodyContent);

            $(document).on("click", ".addEditColumnBtnB", function(event) {
                event.preventDefault();
                const rowId = $(this).data("row-id");
                addEditInput(`columnContainerB_${rowId}_Edit`, "standart_parameter[]", `parameter_${rowId}`, "Example: Berfungsi dengan baik", rowId, 'B');
            });
            $(document).on("click", ".addEditColumnBtnC", function(event) {
                event.preventDefault();
                const rowId = $(this).data("row-id");
                addEditInput(`columnContainerC_${rowId}_Edit`, "metode_pengecekan[]", `metodecheck_${rowId}`, "Example: Dioperasikan", rowId, 'C');
            });
            $(document).on("click", ".removeEditColumnBtnB", function(event) {
                event.preventDefault();
                removeEditInput(this, `inputContainerB_${$(this).data("row-id")}_Edit`);
            });
            $(document).on("click", ".removeEditColumnBtnC", function(event) {
                event.preventDefault();
                removeEditInput(this, `inputContainerC_${$(this).data("row-id")}_Edit`);
            });

            function addEditInput(containerId, inputName, inputIdPrefix, placeholder, rowIdSuffix, columnId) {
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
                newInput.id = `${inputIdPrefix}_${inputGroupCount}_Edit`;
                newInput.placeholder = placeholder;

                const addButton = document.createElement("button");
                addButton.type = "button";
                addButton.className = "btn btn-success btn-circle btn-sm";
                addButton.innerHTML = '<i class="fas fa-plus"></i>';
                addButton.addEventListener("click", function (event) {
                    event.preventDefault();
                    addEditInput(containerId, inputName, inputIdPrefix, placeholder, rowIdSuffix, columnId);
                });

                const removeButton = document.createElement("button");
                removeButton.type = "button";
                removeButton.className = "btn btn-danger btn-circle btn-sm";
                removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
                removeButton.onclick = function () {
                    removeEditInput(this, containerId);
                };

                newInputGroup.appendChild(newInput);
                newInputGroup.appendChild(addButton);
                newInputGroup.appendChild(removeButton);
                inputContainer.appendChild(newInputGroup);

                // Increment the hidden input value
                document.getElementById(`userInputCount_${rowIdSuffix}_Edit`).value = inputGroupCount;
            }

            function removeEditInput(button, containerId) {
                const inputContainer = document.getElementById(containerId);
                if (inputContainer) {
                    const inputGroups = inputContainer.querySelectorAll(".dynamic-input-group");
                    if (inputGroups.length > 1) {
                        const inputGroup = button.closest(".dynamic-input-group"); // Temukan parent terdekat
                        inputGroup.remove(); // Hapus input group yang diklik

                        const rowIdSuffix = containerId.match(/\d+/g)?.[0]; // Ambil angka pertama dari ID
                        const userInputCountElement = document.getElementById(`userInputCount_${rowIdSuffix}_Edit`);
                        if (userInputCountElement) {
                            const currentCount = parseInt(userInputCountElement.value, 10);
                            userInputCountElement.value = currentCount - 1;
                        } else {
                            console.warn(`Hidden input userInputCount_${rowIdSuffix}_Edit not found`);
                        }
                    } else {
                        alert("At least one input must remain.");
                    }
                } else {
                    console.error(`Element with id "${containerId}" not found`);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data:', error);
            $('#modal-data').html('<p>Error fetching data. Please try again.</p>');
        }
    });
});
