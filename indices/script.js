// This script cruises the DOM of Apache's XHTML / HTMLTable
// directory output, and injects useful class names throughout.
//
// It's part of Indices: http://antisleep.com/software/indices

$(document).ready(function(){
  var parentRow = $('tr:nth-child(2)').first();
  if (parentRow && $('td:nth-child(2) a', parentRow).text()=='Parent Directory') {
    parentRow.addClass('row_parentdir');
    $('td',parentRow).addClass('cell_parentdir');
  } else {
    parentRow = null;
  }
  var allTrs = $('tr:not(.row_parentdir) td:nth-child(2)').addClass(function(){
    if ($('a', this).attr('href').match(/\/$/)) {
      return 'dirlink';
    } else {
      return 'filelink';
    }
  });
  var pagecontainer = $("#pagecontainer");
  pagecontainer.fadeIn('slow');
});
