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
    newInput.value = "Type Here!";
    const addButton = document.createElement("button");
    addButton.className = "dynamic-button-add";
    addButton.innerText = "Add";
    addButton.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the form from submitting
        addInput(containerId);
    });
    const removeButton = document.createElement("button");
    removeButton.className = "dynamic-button-delete";
    removeButton.innerText = "Remove";
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
