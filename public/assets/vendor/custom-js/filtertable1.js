$(document).ready(function() {
    $('#preventiveTables tr').each(function() {
      var statusCell = $(this).find('td:eq(7)'); // Assuming the 'status' column is the 7th column (0-indexed)
      var status = statusCell.text().trim();
  
      if (status === '') {
        statusCell.text('SUDAH DI PREVENTIVE');
      } else {
        statusCell.text('BELUM DI PREVENTIVE');
      }
    });
  });