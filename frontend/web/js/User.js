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
        'r=user%2Fget-usernames&useJson=true&query=%QUERY',
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

});