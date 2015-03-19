/**
 * JavaScript file for the Categories view functionality
 */

var gridViewBtnId = "gridViewBtn";
var listViewBtnId = "listViewBtn";

$(document).ready(function() {
  setButtonEnabled("#" + gridViewBtnId, false);
  giveListButtonFocus("#" + gridViewBtnId, "#" + listViewBtnId);
});
