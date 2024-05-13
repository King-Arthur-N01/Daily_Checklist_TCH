$(document).ready(function() {
    $('#preventiveTables tr').each(function() {
      var statusCell = $(this).find('td:eq(7)');
      var rejectCell = $(this).find('td:eq(8)');
      var status = statusCell.text().trim();
      var reject = rejectCell.text().trim();
      if (status === '') {
        statusCell.text('BELUM DI KOREKSI');
      } else {
        statusCell.text('SUDAH DI KOREKSI');
      }
      if (reject !== '') {
        statusCell.text('SUDAH DI REJECT');
        $(this).css("background-color", "red");
      }
    });
  });