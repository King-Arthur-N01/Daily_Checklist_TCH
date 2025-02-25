window.onload = function () {
    const customButton = document.getElementById("customButton");
    const myFile = document.getElementById("importExcel");

    customButton.addEventListener("click", (event) => {
        event.preventDefault(); // Prevent the default action
        myFile.click();
    });
    myFile.addEventListener("change", () => {
        const fileName = myFile.value.split("\\").pop();
        customButton.innerHTML = fileName || "Select a file";
    });
};
