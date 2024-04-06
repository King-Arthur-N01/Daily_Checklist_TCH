document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('filterButton').addEventListener('click', function () {
        filterItems();
    });
});

function filterItems() {
    var filterData = new filterData(document.getElementById('filterForm'));
    fetch('/items/filter', {
        method: 'POST',
        body: filterData,
        headers: {
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update table with filtered data
        updateTable(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function updateTable(data) {
    var tableBody = document.getElementById('itemsTable').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = ''; // Clear existing table rows

    data.forEach(item => {
        var row = tableBody.insertRow();
        row.innerHTML = '<td>' + item.name + '</td>' +
                        '<td>' + item.category + '</td>';
        // Add more cells if needed
    });
}
