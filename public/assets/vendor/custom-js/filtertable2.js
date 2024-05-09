$(document).ready(function() {
    $('#preventiveTables tr').each(function() {
      var statusCell = $(this).find('td:eq(7)'); // Assuming the 'status' column is the 7th column (0-indexed)
      var status = statusCell.text().trim();

      if (status === '') {
        statusCell.text('BELUM DI SETUJUI');
      } else {
        statusCell.text('SUDAH DI SETUJUI');
      }
    });
  });
