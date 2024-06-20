const selectStyleCheckbox = document.getElementById("select-style-checkbox");
const checkboxButtons = selectStyleCheckbox.querySelectorAll('input[type="checkbox"]');

// Add event listener to each checkbox button
checkboxButtons.forEach((checkbox) => {
    checkbox.addEventListener("change", () => {
        // Remove 'selected' class from all options
        checkboxButtons.forEach((checkbox) => {
            checkbox.closest(".option").classList.remove("selected");
        });

        // Add 'selected' class to the selected option
        checkbox.closest(".option").classList.add("selected");
    });
});

// Set initial selected option
checkboxButtons[0].dispatchEvent(new Event("change"));
