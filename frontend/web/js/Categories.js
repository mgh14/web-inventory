/**
 * JavaScript file for the Categories view functionality
 */

var gridViewBtnId = "gridViewBtn";
var listViewBtnId = "listViewBtn";

$(document).ready(function() {
  // set view buttons behavior
  setButtonEnabled("#" + gridViewBtnId, false);
  giveListButtonFocus("#" + gridViewBtnId, "#" + listViewBtnId);

  // add behavior for showing the category change input box
  $('.categoryName').click(function() {
    $(this).hide();
    $(this).next(".changeCategoryNameContainer").show();
  });

  // add behavior of 'set category' button
  $('.setCategoryNameBtn').click(function() {
    var displayNameElement = $(this).parent().prev(".categoryName");
    var inputElement = $(this).prev().children(".categoryNameInput");
    var buttonElement = $(this);
    var loaderElement = $(buttonElement).next().next().next();

    // check current and new category names are different
    var oldCategoryName = $.trim($(displayNameElement).html());
    var newCategoryName = $.trim($(inputElement).val());
    if (oldCategoryName == newCategoryName) {
      hideCategoryNameSetterContainer(this);
      return;
    }

    var id = $.trim($(this).parent().siblings(".categoryId").first().html());
    $(loaderElement).css("display", "inline-block");
    $.ajax({
      url: "?r=sports-categories%2Fedit-category",
      type: 'POST',
      data: "id=" + id + "&newName=" + encodeURIComponent(newCategoryName),
      success: function(data) {
        // error case
        if (data.substring("failure") > -1) {
          $(inputElement).val(oldCategoryName);
          alert('failure');
        }

        // success case
        $(displayNameElement).html(newCategoryName);
        $(inputElement).val(newCategoryName);
        hideCategoryNameSetterContainer($(buttonElement));
      },
      error: function() {
        handleGeneralError();
        $(inputElement).val(oldCategoryName);
      },
      complete: function() {
        $(loaderElement).hide();
      }
    });
  });

  // add behavior for hiding the category change input box on 'cancel'
  $('.cancelNewCategoryNameBtn').click(function() {
    hideCategoryNameSetterContainer($(this));
  });
});

// Function for hiding the category change input box on 'cancel'
function hideCategoryNameSetterContainer(btnElement) {
  $(btnElement).parent().prev(".categoryName").show();
  $(btnElement).parent().hide();
}
