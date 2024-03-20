function mergeCells() {
    let db = document.getElementById("datatables");
    let dbRows = db.rows;
    let lastValue1 = "";
    let lastValue2 = "";
    let lastCounter = 1;
    let lastRow = 0;
    for (let i = 0; i < dbRows.length; i++) {
        let thisValue1 = dbRows[i].cells[0].innerHTML;
        if (thisValue1 == lastValue1) {
            lastCounter++;
            dbRows[lastRow].cells[0].rowSpan = lastCounter;
            dbRows[i].cells[0].style.display = "none";
        } else {
            dbRows[i].cells[0].style.display = "table-cell";
            lastValue1 = thisValue1;
            lastCounter = 1;
            lastRow = i;
        }
    }
    for (let i = 0; i < dbRows.length; i++) {
        let thisValue2 = dbRows[i].cells[1].innerHTML;
        if (thisValue2 == lastValue2) {
            lastCounter++;
            dbRows[lastRow].cells[1].rowSpan = lastCounter;
            dbRows[i].cells[1].style.display = "none"; // Hide cells in the second column too
        } else {
            dbRows[i].cells[1].style.display = "table-cell"; // Show cells in the second column
            lastValue2 = thisValue2;
            lastCounter = 1;
            lastRow = i;
        }
    }
}
window.onload = mergeCells;
