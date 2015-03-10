$(document).ready(function() {
  var movies = new Bloodhound({
    datumTokenizer: function (datum) {
      return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: 'http://localhost/public_html/mr-test-two/frontend/web/index.php?r=user%2Fget-users&query=%QUERY',
      maxParallelRequests: 1,
      ajax: {
        type: "GET",
        timeout: 10000
      },
      triggerLength: 3,
      filter: function (users) {
        return $.map(users, function(usernameArray) {
          return {value: usernameArray.username}
        })
      }
    }
  });

  movies.initialize();

  $('#the-basics .typeahead').typeahead(null, {
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