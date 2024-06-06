document.getElementById("addInputBtn1").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent the form from submitting
    addInput("inputContainer1");
});

document.getElementById("addInputBtn2").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent the form from submitting
    addInput("inputContainer2");
});

document.getElementById("addInputBtn3").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent the form from submitting
    addInput("inputContainer3");
});
function addInput(containerId) {
    const inputContainer = document.getElementById(containerId);
    const newInputGroup = document.createElement("div");
    newInputGroup.className = "dynamic-input-group";
    const newInput = document.createElement("input");
    newInput.type = "text";
    newInput.className = "col-12";
    newInput.placeholder = "Input text";
    const addButton = document.createElement("button");
    addButton.className = "btn btn-success btn-circle btn-sm";
    addButton.innerHTML = '<i class="fas fa-plus"></i>';
    addButton.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the form from submitting
        addInput(containerId);
    });
    const removeButton = document.createElement("button");
    removeButton.className = "btn btn-danger btn-circle btn-sm";
    removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>';
    removeButton.onclick = function () {
        removeInput(this);
    };
    newInputGroup.appendChild(newInput);
    newInputGroup.appendChild(addButton);
    newInputGroup.appendChild(removeButton);
    inputContainer.appendChild(newInputGroup);
}
function removeInput(button) {
    const inputGroup = button.parentNode;
    inputGroup.parentNode.removeChild(inputGroup);
}
