const selectStyleRadio = document.getElementById("select-style-radio");
const radioButtons = selectStyleRadio.querySelectorAll('input[type="radio"]');

// Add event listener to each radio button
radioButtons.forEach((radio) => {
    radio.addEventListener("change", () => {
        // Remove 'selected' class from all options
        radioButtons.forEach((radio) => {
            radio.closest(".option").classList.remove("selected");
        });

        // Add 'selected' class to the selected option
        radio.closest(".option").classList.add("selected");
    });
});

// Set initial selected option
radioButtons[0].dispatchEvent(new Event("change"));
