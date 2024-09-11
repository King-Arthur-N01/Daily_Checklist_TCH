function combineCreateByUsers() {
    const createBy1 = document.getElementById("create_by_1").value;
    const createBy2 = document.getElementById("create_by_2").value;
    const createBy3 = document.getElementById("create_by_3").value;
    const createBy4 = document.getElementById("create_by_4").value;

    const combinedValue = [createBy1, createBy2, createBy3, createBy4].filter(value => value !== '0');
    document.getElementById("combined_create_by").value = combinedValue;
}
// Ensure the combined value is set before form submission
document.getElementById("registerform").addEventListener("submit", function () {
    combineCreateByUsers();
});

function disableDoubleSelectUsers() {
    // Get all selected values
    const selectedValues = [];
    $('select[id^="create_by_"]').each(function () {
        const value = $(this).val();
        if (value !== "0") {
            selectedValues.push(value);
        }
    });

    // Iterate over each select element to disable/enable options
    $('select[id^="create_by_"]').each(function () {
        const currentSelect = $(this);
        const currentVal = currentSelect.val();
        currentSelect.find("option").each(function () {
            const option = $(this);
            if (selectedValues.includes(option.val()) && option.val() !== currentVal) {
                option.prop("disabled", true);
            } else {
                option.prop("disabled", false);
            }
        });
    });
}

// Attach the change event listener to all select elements
$('select[id^="create_by_"]').on("change", function () {
    disableDoubleSelectUsers();
});
