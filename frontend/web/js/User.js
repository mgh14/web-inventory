// we use this variable to avoid multiple Bloodhound requests
var bloodhoundRunning = false;

$(document).ready(function() {
  // set up search typeahead
  var movies = new Bloodhound({
    datumTokenizer: function (datum) {
      return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      maxParallelRequests: 0,
      url: 'http://localhost/public_html/mr-test-two/frontend/web/index.php?' +
        'r=user%2Fget-usernames&useJson=true&query=%QUERY&limit=5',
      ajax: {
        type: "GET",
        timeout: 10000,
        beforeSend: function(jqXHR, settings) {
          // only allow one request at a time
          if (bloodhoundRunning) {
            return false;
          }

          bloodhoundRunning = true;
          $('#loader1').show();
        },
        complete: function(jqXHR, textStatus) {
          bloodhoundRunning = false;
          $('#loader1').hide();
        }
      },
      filter: function (users) {
        return $.map(users, function(usernameArray) {
          return {value: usernameArray.username}
        })
      }
    }
  });

  movies.initialize();

  $('#the-basics .typeahead').typeahead(null, {
    highlight: true,
    minLength: 1,
    displayKey: 'value',
    source: movies.ttAdapter(),
    templates: {
      empty: ['<div class="empty-message">',
        'unable to find any users',
        '</div>'
        ].join('\n'),
      suggestion: function (value) {
        return '<p class="repo-language"><b>' + value.value + '</b></p>'
      }
    }
  });

  // set up "search" button
  $('#searchUsersBtn').click(function() {
    var query = $('#searchBar').val();
    loadPaginatedUserSetResults("?r=user%2Fget-user-profiles&query=" +
      query + "&offset=0", query);
  });

  // set up 'grid' and 'list' views
  $('#gridViewBtn').click(function() {
    $('#users-grid').show();
    $('#users-list').hide();
  });

  $('#listViewBtn').click(function() {
    $('#users-grid').hide();
    $('#users-list').show();
  })

});

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
