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
}

function giveListButtonFocus(gridViewBtnSelector, listViewBtnSelector) {
  $(gridViewBtnSelector).removeClass(btnPrimaryCssClassName);
  $(listViewBtnSelector).addClass(btnPrimaryCssClassName);
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
