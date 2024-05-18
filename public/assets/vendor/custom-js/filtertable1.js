$(document).ready(function() {
    $('#preventiveTables1 tr').each(function() {
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
        $(this).css("background-color", "rgba(255, 0, 0, 0.8)");
      }
    });
    $('#preventiveTables2 tr').each(function() {
        var statusCell = $(this).find('td:eq(7)');
        var rejectCell = $(this).find('td:eq(8)');
        var status = statusCell.text().trim();
        var reject = rejectCell.text().trim();
        if (status === '') {
          statusCell.text('BELUM DI SETUJUI');
        } else {
          statusCell.text('SUDAH DI SETUJUI');
        }
        if (reject !== '') {
          statusCell.text('SUDAH DI REJECT');
          $(this).css("background-color", "rgba(255, 0, 0, 0.8)");
        }
      });
  });