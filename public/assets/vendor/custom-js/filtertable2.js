// Get the input element and table
var input = document.getElementById("searchInput");
var table = document.getElementById("datatables");
var rows = table.getElementsByTagName("tr");

// Add an event listener to the search input
input.addEventListener("input", function () {
    var filter = input.value.toUpperCase();

    // Loop through all table rows and hide those that don't match the search query
    for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName("td");

        // Check if any cell value matches the search query
        var found = false;
        for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];
            var cellValue = cell.textContent || cell.innerText;
            if (cellValue.toUpperCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        // Show or hide the row based on the search result
        row.style.display = found ? "" : "none";
    }
});
