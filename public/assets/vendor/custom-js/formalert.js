document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("registerform");
    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        const errorMessagesDiv = document.getElementById("errorMessages");
        if (errorMessagesDiv) {
            errorMessagesDiv.innerHTML = ""; // Clear any existing error messages
            const requiredFields = form.querySelectorAll("[required]");
            requiredFields.forEach((field) => {
                if (field.value.trim() === "") {
                    const fieldName = field.getAttribute("name");
                    const errorMessage = document.createElement("p");
                    errorMessage.textContent = `${fieldName} is required.`;
                    errorMessagesDiv.appendChild(errorMessage);
                }
            });
            // If there are no error messages, proceed with form submission
            if (errorMessagesDiv.innerHTML === "") {
                form.submit(); // Submit the form
            }
        } else {
            console.log
            console.error("Error messages container not found.");
        }
    });
});
