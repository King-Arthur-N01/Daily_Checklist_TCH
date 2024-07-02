document.getElementById("addInputBtn1").addEventListener("click", function (event) {
    event.preventDefault();
        addInput(
            "inputContainer1",
            "bagian_yang_dicheck[]",
            "Example: Push Button"
        );
    });

document.getElementById("addInputBtn2").addEventListener("click", function (event) {
        event.preventDefault();
        addInput(
            "inputContainer2",
            "standart_parameter[]",
            "Example: Berfungsi dengan baik"
        );
    });

document.getElementById("addInputBtn3").addEventListener("click", function (event) {
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
            alert("Setidaknya satu Input harus tetap ada.");
        }
    } else {
        console.error(`Element with id "${containerId}" not found`);
    }
}
