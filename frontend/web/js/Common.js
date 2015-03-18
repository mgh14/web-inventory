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

function setUpGridAndListView(gridViewBtnSelector, listViewBtnSelector,
    gridContainerSelector, listContainerSelector) {

    // set up 'grid' and 'list' views
    $(gridViewBtnSelector).click(function() {
        $(gridContainerSelector).show();
        $(listContainerSelector).hide();
    });

    $(listViewBtnSelector).click(function() {
        $(gridContainerSelector).hide();
        $(listContainerSelector).show();
    })
}
