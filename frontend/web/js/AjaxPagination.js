function loadPaginatedUserSetResults(url, query) {
  $.get(url,
    function (result) {
      var html = $.parseHTML(result);

      // extract 'div' elements from parsed html
      var htmlDivs = [];
      $.each(html, function (i, el) {
        if (el.nodeName.toLowerCase() == "div") {
          htmlDivs.push(el);
        }
      });

      $('#users-grid').html(htmlDivs[0]);
      $('#users-list').html(htmlDivs[1]);
      $('#paginationContainer').html(htmlDivs[2]);

      // set up 'previous' button
      if ($("#prevUserSetBtn").length > 0) {
        $('#prevUserSetBtn').click(function() {
          var prevLink = $('<div/>').html($('#prevLink').html().trim()).text();
          loadPaginatedUserSetResults(prevLink, query);
        });
      }

      // set up 'next' button
      if ($("#nextUserSetBtn").length > 0) {
        //alert('next');
        $('#nextUserSetBtn').click(function () {
          var nextLink = $('<div/>').html($('#nextLink').html().trim()).text();
          loadPaginatedUserSetResults(nextLink, query);
        });
      }
    }
  ).error(function(result) {
      alert('error');
    }
  ).always(function(result) {

    }
  );
}