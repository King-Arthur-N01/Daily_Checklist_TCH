function selectCheckbox() {
    const selectStyleCheckbox = document.getElementById("select-style-checkbox");
    const checkboxButtons = selectStyleCheckbox.querySelectorAll('input[type="checkbox"]');

    checkboxButtons.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            checkboxButtons.forEach((checkbox) => {
                checkbox.closest(".option").classList.remove("selected");
            });
            checkbox.closest(".option").classList.add("selected");
        });
    });

    // Set initial selected option
    checkboxButtons[0].dispatchEvent(new Event("change"));
}
