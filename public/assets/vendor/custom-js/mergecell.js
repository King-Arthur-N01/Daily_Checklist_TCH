function mergeCells() {
    let db = document.getElementById("datatables");
    let dbRows = db.rows;
    let lastValue1 = "";
    let lastValue2 = "";
    let lastValue3 = "";
    let lastValue4 = "";
    let lastValue5 = "";
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
    // for (let i = 0; i < dbRows.length; i++) {
    //     let thisValue3 = dbRows[i].cells[2].innerHTML;
    //     if (thisValue3 == lastValue3) {
    //         lastCounter++;
    //         dbRows[lastRow].cells[2].rowSpan = lastCounter;
    //         dbRows[i].cells[2].style.display = "none"; // Hide cells in the second column too
    //     } else {
    //         dbRows[i].cells[2].style.display = "table-cell"; // Show cells in the second column
    //         lastValue3 = thisValue3;
    //         lastCounter = 1;
    //         lastRow = i;
    //     }
    // }
    // for (let i = 0; i < dbRows.length; i++) {
    //     let thisValue4 = dbRows[i].cells[3].innerHTML;
    //     if (thisValue4 == lastValue4) {
    //         lastCounter++;
    //         dbRows[lastRow].cells[3].rowSpan = lastCounter;
    //         dbRows[i].cells[3].style.display = "none"; // Hide cells in the second column too
    //     } else {
    //         dbRows[i].cells[3].style.display = "table-cell"; // Show cells in the second column
    //         lastValue4 = thisValue4;
    //         lastCounter = 1;
    //         lastRow = i;
    //     }
    // }
    // for (let i = 0; i < dbRows.length; i++) {
    //     let thisValue5 = dbRows[i].cells[4].innerHTML;
    //     if (thisValue5 == lastValue5) {
    //         lastCounter++;
    //         dbRows[lastRow].cells[4].rowSpan = lastCounter;
    //         dbRows[i].cells[4].style.display = "none"; // Hide cells in the second column too
    //     } else {
    //         dbRows[i].cells[4].style.display = "table-cell"; // Show cells in the second column
    //         lastValue5 = thisValue5;
    //         lastCounter = 1;
    //         lastRow = i;
    //     }
    // }
}
window.onload = mergeCells;
