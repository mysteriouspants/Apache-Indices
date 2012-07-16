// This script cruises the DOM of Apache's XHTML / HTMLTable
// directory output, and injects useful class names throughout.
//
// It's part of Indices: http://antisleep.com/software/indices

$(document).ready(function(){
  // apply better styling
  $('#indices-content table').each(function(){
    $(this).addClass('table table-bordered table-striped').attr('id', 'indices-table');
  });

  // chop out the header row and drop it into a table header
  var headerRow = $('#indices-table tbody tr:first-child').detach();
  $('#indices-table tbody').before('<thead>'+headerRow.html()+'</thead>');
});
