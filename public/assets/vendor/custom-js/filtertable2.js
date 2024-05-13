function mergeCells() {
    var table = document.getElementById("myTable");
    var rows = table.getElementsByTagName("tr");

    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName("td");
        var column1Value = cells[0].textContent;
        var column2Value = cells[1].textContent;

        if (
            column1Value === "your_filter_criteria_1" &&
            column2Value === "your_filter_criteria_2"
        ) {
            row.style.backgroundColor = "red";
        }
    }
}
