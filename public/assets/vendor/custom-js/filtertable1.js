$(document).ready(function() {
    $('#preventiveTables1 tr').each(function() {
      var statusCell = $(this).find('td:eq(7)');
      var status = statusCell.text().trim();
      if (status === '') {
        statusCell.text('BELUM DI KOREKSI');
      } else {
        statusCell.text('SUDAH DI KOREKSI');
      }
    });
    $('#preventiveTables2 tr').each(function() {
        var statusCell = $(this).find('td:eq(7)');
        var status = statusCell.text().trim();
        if (status === '') {
          statusCell.text('BELUM DI SETUJUI');
        } else {
          statusCell.text('SUDAH DI SETUJUI');
        }
      });
  });