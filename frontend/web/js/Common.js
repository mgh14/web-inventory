/**
 * JavaScript for all common functionality throughout the website
 */

/**
 * For views supporting grid and list views, this function
 * sets up the appropriate actions to take when each view is
 * loaded into the browser window
 *
 * @param gridViewBtnSelector
 * @param listViewBtnSelector
 * @param gridContainerSelector
 * @param listContainerSelector
 */

var btnPrimaryCssClassName = 'btn-primary';

///////////////////// GRID AND LIST VIEW FUNCTIONS ////////////////////////

function setUpGridAndListView(gridViewBtnSelector, listViewBtnSelector,
    gridContainerSelector, listContainerSelector) {

  // set up 'grid' view
  $(gridViewBtnSelector).click(function() {
    showGridView(gridViewBtnSelector, listViewBtnSelector,
      gridContainerSelector, listContainerSelector);
  });

  // set up 'list' view
  $(listViewBtnSelector).click(function() {
    showListView(gridViewBtnSelector, listViewBtnSelector,
      gridContainerSelector, listContainerSelector);
  });
}

function showGridView(gridViewBtnSelector, listViewBtnSelector,
  gridContainerSelector, listContainerSelector) {

  giveGridButtonFocus(gridViewBtnSelector, listViewBtnSelector);

  $(gridContainerSelector).show();
  $(listContainerSelector).hide();
}

function showListView(gridViewBtnSelector, listViewBtnSelector,
  gridContainerSelector, listContainerSelector) {

  giveListButtonFocus(gridViewBtnSelector, listViewBtnSelector);

  $(gridContainerSelector).hide();
  $(listContainerSelector).show();
}

function giveGridButtonFocus(gridViewBtnSelector, listViewBtnSelector) {
  $(gridViewBtnSelector).addClass(btnPrimaryCssClassName);
  $(listViewBtnSelector).removeClass(btnPrimaryCssClassName);

  setButtonEnabled(gridViewBtnSelector, true);
}

function giveListButtonFocus(gridViewBtnSelector, listViewBtnSelector) {
  $(gridViewBtnSelector).removeClass(btnPrimaryCssClassName);
  $(listViewBtnSelector).addClass(btnPrimaryCssClassName);

  setButtonEnabled(listViewBtnSelector, true);
}

function focusActiveGridOrListView(gridViewBtnSelector, listViewBtnSelector,
  gridContainerSelector, listContainerSelector) {

  if ($(gridContainerSelector).is(":visible")) {
    giveGridButtonFocus(gridViewBtnSelector, listViewBtnSelector);
  }

  if ($(listContainerSelector).is(":visible")) {
    giveListButtonFocus(gridViewBtnSelector, listViewBtnSelector);
  }
}

function setGridAndListButtonEnabled(gridViewBtnSelector,
  listViewBtnSelector, enabled) {

  setButtonEnabled(gridViewBtnSelector, enabled);
  setButtonEnabled(listViewBtnSelector, enabled);
}

////////////////// GENERAL BUTTON FUNCTIONS /////////////////////////

function setButtonEnabled(btnSelector, enabled) {
  $(btnSelector).prop("disabled", (enabled == true) ? "" : "disabled");
}

////////////////// ERROR FUNCTIONS ///////////////////////

function handleError(result) {
  alert('There was an error. Please contact your system administrator.')
}
