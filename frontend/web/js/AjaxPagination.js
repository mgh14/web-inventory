function setUpPaginationButtons(query, callback) {
    // set up 'first' button
    if (0 < $('#firstSetBtn').length && 0 < $('#firstLink').length) {
        $('#firstSetBtn').click(function () {
            var firstLink = $('<div/>').html($('#firstLink').html().trim()).text();
            eval(callback + "(\"" + firstLink + "\", \"" + query + "\")");
        })
    }

    // set up 'previous' button
    if (0 < $('#prevSetBtn').length && 0 < $('#prevLink').length) {
        $('#prevSetBtn').click(function () {
            var prevLink = $("<div/>").html($('#prevLink').html().trim()).text();
            eval(callback + "(\"" + prevLink + "\", \"" + query + "\")");
        });
    }

    // set up 'next' button
    if (0 < $('#nextSetBtn').length && 0 < $('#nextLink').length) {
        $('#nextSetBtn').click(function () {
            var nextLink = $('<div/>').html($('#nextLink').html().trim()).text();
            eval(callback + "(\"" + nextLink + "\", \"" + query + "\")");
        });
    }

    // set up 'last' button
    if (0 < $('#lastSetBtn').length && 0 < $('#lastLink').length) {
        $('#lastSetBtn').click(function () {
            var lastLink = $('<div/>').html($('#lastLink').html().trim()).text();
            eval(callback + "(\"" + lastLink + "\", \"" + query + "\")");
        })
    }
}