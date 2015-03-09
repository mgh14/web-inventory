/**
 * @var modelId -- model object for the item request
 * @var commentIds -- array holding comment ID of each comment
 */

$(document).ready(function () {
  // assign 'open/close' functionality to button
  $('#openOrClosedRequest_' + modelId).click(function () {
    var openOrClosed = $('#openOrClosedRequestStatus_'
      + modelId).text().trim();

    $.post('?r=item-request%2Fchange-request-status',
      {'itemRequestId': modelId, 'openOrClosed': openOrClosed},
      function (result) {
        $('#openOrClosedRequestStatus_' + modelId)
          .text((openOrClosed == '1') ? 0 : 1);
        $('#openOrClosedRequest_' + modelId)
          .text((openOrClosed == '1') ? 'Open' : 'Close');
    })
    .error(function(result) {
      handleError(result);
    });
  });

  $.each(commentIds, function (index, value) {
    var commentId = commentIds[index];
    addCommentFunctionality(commentId);
  });

  // add new comment functionality
  $('#addComment').click(function () {
    var content = ($('#newCommentEditable').val()).trim();
    $.post('?r=item-request%2Fadd-new-comment',
      {'itemRequestId': modelId, 'content': content},
      function (result) {
        var commentArray = JSON.parse(result);
        $(commentArray[1]).insertBefore('#newCommentContainer');
        addCommentFunctionality(commentArray[0]);

        $('#newCommentEditable').val('');
    })
    .error(function(result) {
      handleError(result);
    });
  });

  function handleError(result) {
    alert('There was an error. Please contact your system administrator.')
  }

  function resetEdit(commentId) {
    $('#commentActive_' + commentId).text(0);

    $('#comment_' + commentId).show();
    $('#commentEditBtn_' + commentId).show();
    $('#commentDeleteBtn_' + commentId).show();

    $('#commentEditable_' + commentId).hide();
    $('#commentSaveBtn_' + commentId).hide();
    $('#commentCancelBtn_' + commentId).hide();
  }

  function addCommentFunctionality(commentId) {
    // hide hidden elements
    $('#commentEditable_' + commentId).hide();
    $('#commentSaveBtn_' + commentId).hide();
    $('#commentCancelBtn_' + commentId).hide();

    // bind 'show comment' functionality to 'edit comment' button
    $('#commentEditBtn_' + commentId).click(function () {
      $('#commentActive_' + commentId).text(1);

      $('#comment_' + commentId).hide();
      $('#commentEditBtn_' + commentId).hide();
      $('#commentDeleteBtn_' + commentId).hide();

      $('#commentEditable_' + commentId).show();
      $('#commentSaveBtn_' + commentId).show();
      $('#commentCancelBtn_' + commentId).show();
    });

    // bind 'delete comment' functionality to 'delete comment' button
    $('#commentDeleteBtn_' + commentId).click(
      function() {
        $('#commentContainer_' + commentId).remove();

        $.post('?r=item-request%2Fdelete-comment',
          {'itemRequestId': modelId, 'commentId': commentId}
        )
        .error(
          function(result) {
            handleError(result);
          }
        );
      }
    );

    // bind 'save' functionality to 'save' button
    $('#commentSaveBtn_' + commentId).click(function () {
      var originalText = ($('#comment_' + commentId).text()).trim();
      var changedText = ($('#commentEditable_' + commentId).val()).trim();
      if (originalText == changedText) {
        resetEdit(commentId);
        return;
      }

      $.post('?r=item-request%2Fsave-edited-comment',
        {'commentId': commentId, 'newContent': changedText},
        function (result) {
          $('#comment_' + commentId).html(changedText);
          resetEdit(commentId);
        })
        .error(function(result) {
          handleError(result);
        });
    });

    // bind 'cancel edit' functionality to 'cancel' button
    $('#commentCancelBtn_' + commentId).click(function () {
      resetEdit(commentId);
    });
  }
});